<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Order;
use App\Models\UserProfit;
use App\Models\User;
use App\Models\Purchase;
use App\Models\ProfitList;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        return view('pages.dashboards.index');
    }

    // protected function getCostPerUnit($asin)
    // {
    //     $cost_per_unit = Purchase::where('asin', $asin)->first()->cost_per_unit ?? null;
    //     return $cost_per_unit;
    // }

    public function admin()
    {
        $chart = Order::all();

        // Get the current date as per your timezone
        $currentDate = date('Y-m-d');

        // Initialize the variables
        $chart_d = [];
        $chart_w = [];
        $chart_m = [];
        $chart_y = [];

        // Loop through each order and store data in respective variables
        foreach ($chart as $order) {
            $orderDate = $order->order_date;
            $orderTime = $order->order_time;
            $itemTotal = $order->item_total;

            if ($orderDate === $currentDate) {
                $chart_d[] = [
                    'order_date' => $orderDate . ' ' . $orderTime,
                    'item_total' => $itemTotal
                ];
            }

            if (Carbon::parse($orderDate)->isSameWeek($currentDate)) {
                $chart_w[] = [
                    'order_date' => $orderDate . ' ' . $orderTime,
                    'item_total' => $itemTotal
                ];
            }

            if (Carbon::parse($orderDate)->format('Y-m') === date('Y-m')) {
                $chart_m[] = [
                    'order_date' => $orderDate . ' ' . $orderTime,
                    'item_total' => $itemTotal
                ];
            }

            if (Carbon::parse($orderDate)->format('Y') === date('Y')) {
                $chart_y[] = [
                    'order_date' => $orderDate,
                    'item_total' => $itemTotal
                ];
            }
        }

        // Fetch the 10 most recent orders
        $orders = Order::latest()->take(10)->get();
        foreach ($orders as $order) {
            // Subtract 'cost_per_unit' from 'profit'
            $profit = $order->item_total - $order->warehouse_fee - $order->amazon_fee - $order->shipping_fee - $order->cost_per_unit;

            // Update the 'profit' field in the Order model
            $order->update([
                'profit' => $profit,
            ]);
        }
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        return view('pages.dashboards.admin', ['orders' => $orders]);
    }

    public function client(Request $request)
    {
        $client = new \stdClass();;
        $currentMonthStartDate = now()->startOfMonth();
        $currentMonthEndDate = now()->endOfMonth();
        $lastMonthStartDate = now()->subMonths(1)->startOfMonth();
        $lastMonthEndDate = now()->subMonths(1)->endOfMonth();
        $yearStartDate = now()->startOfYear();
        $yearEndDate = now()->endOfYear();

        $logged_user = Auth::user();
        $data = $request->query();
        $user_id =  isset($data['id']) ? $data['id'] : '';
        $totalClients = User::where('role', 'Client')->count();
        if ($logged_user->role !== 'Admin') {
            $client->totalPositions = User::where('email', $logged_user->email)->sum('position');
        } else {
            $client->totalPositions = User::where('role', 'Client')->sum('position'); // This is clients' sum case.
        }

        $client->totalProfitLastMonth = Order::whereBetween('order_date', [$lastMonthStartDate, $lastMonthEndDate])->sum('profit');
        $client->totalProfitYear = Order::whereBetween('order_date', [$yearStartDate, $yearEndDate])->sum('profit');
        $client->totalProfitAllTime = Order::sum('profit');

        $client->totalUnitsShippedAllTime = Order::sum('quantity');

        if ($logged_user->role !== 'Admin') {
            $profitList = ProfitList::where('user_id', $logged_user->id)->get();
        } else {
            $profitList = ProfitList::where('user_id', $user_id)->get();
        }

        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        return view('pages.dashboards.client', compact('client', 'profitList'));
    }

    public function userProfits()
    {
        $currentMonthStartDate = now()->startOfMonth();
        $currentMonthEndDate = now()->endOfMonth();

        $totalPositions = User::where('role', 'Client')->sum('position');

        $totalProfitCurrentMonth = Order::whereBetween('order_date', [$currentMonthStartDate, $currentMonthEndDate])->sum('profit');

        if ($totalPositions > 0) {
            $profitPerPosition = ($totalProfitCurrentMonth * 0.7) / $totalPositions;
        } else {
            $profitPerPosition = 0;
        }

        $totalProfit = $profitPerPosition * $totalPositions;

        $userProfit = new UserProfit;

        $userProfit->date_range = "{$currentMonthStartDate->format('m/d')} - {$currentMonthEndDate->format('m/d')}";
        $userProfit->position = $totalPositions;
        $userProfit->profit_per_position = $profitPerPosition;
        $userProfit->total_profit = $totalProfit;

        // Save the UserProfit record
        $userProfit->save();

        $user_profits = UserProfit::paginate(10);

        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);
        return view('pages.dashboards.userProfits', ['user_profits' => $user_profits]);
    }

    public function orders()
    {
        $orders = new Order;
        ini_set('max_execution_time', 500);

        // get accessToken
        $response = Http::post('https://api.amazon.com/auth/o2/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => env('LWA_REFRESH_TOKEN'),
            'client_id' => env('LWA_CLIENT_ID'),
            'client_secret' => env('LWA_CLIENT_SECRET')
        ]);

        $accessToken = $response->json()['access_token'];

        // get ReportID and DocumentId
        $response = Http::withHeaders([
            'x-amz-access-token' => $accessToken
        ])->get('https://sellingpartnerapi-na.amazon.com/reports/2021-06-30/reports', [
            'MarketplaceIds' => env('MARKET_PLACE_ID'),
            'reportTypes' => 'GET_V2_SETTLEMENT_REPORT_DATA_XML'
        ]);

        $reports = $response->json();
        $documentIds = Arr::pluck($reports['reports'], 'reportDocumentId');

        // get Reports Url
        $reports_urls = [];

        foreach ($documentIds as $item) {
            $response = Http::withHeaders([
                'x-amz-access-token' => $accessToken
            ])->get("https://sellingpartnerapi-na.amazon.com/reports/2021-06-30/documents/{$item}");

            $reports_url = $response->json();
            $reports_urls[] = $reports_url;
        }

        // get Reports Data
        $reports_data = [];

        foreach ($reports_urls as $item) {
            if (!isset($item['url'])) {
                continue;
            }

            $url = $item['url'];
            $response = Http::get($url);

            $body = $response->body();

            // If the response is XML, you can decide how to handle it.
            // For instance, you might want to convert it to an array or a JSON string:
            $xml = simplexml_load_string($body);
            $json = json_encode($xml);
            $array = json_decode($json, TRUE);

            $reports_data[] = $array;

            // get Shipping fee
            $data = $reports_data; // assign your data to $data variable
            $shippingServices = [];

            foreach ($data as $item) {
                if (isset($item['Message']['SettlementReport']['OtherTransaction'])) {
                    foreach ($item['Message']['SettlementReport']['OtherTransaction'] as $transaction) {
                        if ($transaction['TransactionType'] == 'ShippingServices') {
                            $shippingServices[] = [
                                'AmazonOrderID' => $transaction['AmazonOrderID'],
                                'Amount' => $transaction['Amount']
                            ];
                        }
                    }
                }
            }
        }
        // dd($shippingServices);

        // get OrderID
        $response = Http::withHeaders([
            'x-amz-access-token' => $accessToken
        ])->get('https://sellingpartnerapi-na.amazon.com/orders/v0/orders', [
            'MarketplaceIds' => env('MARKET_PLACE_ID'),
            'CreatedAfter' => '2023-07-01'
        ]);

        $payload = $response->json();
        $orders_data = $payload['payload']['Orders'];

        $order_array = [];
        $order_items_array = [];

        foreach ($orders_data as $item) {
            if ($item['OrderStatus'] == 'Shipped') {
                $order_array[] = $item;
                $order_id = $item['AmazonOrderId'];

                $matchedShippingService = array_filter($shippingServices, function ($shippingService) use ($order_id) {
                    return $shippingService["AmazonOrderID"] == $order_id;
                });

                if (!empty($matchedShippingService)) {
                    $amountKey = array_key_first($matchedShippingService); // Get the first key
                    $shipping_fee = abs($matchedShippingService[$amountKey]['Amount']); // Use the first key to get the absolute Amount
                } else {
                    $shipping_fee = 0;
                }

                $shipping_carrier = isset($item['AutomatedShippingSettings']['AutomatedCarrierName']) ? $item['AutomatedShippingSettings']['AutomatedCarrierName'] : '';

                // get data from OrderId
                $response = Http::withHeaders([
                    'x-amz-access-token' => $accessToken
                ])->get("https://sellingpartnerapi-na.amazon.com/orders/v0/orders/{$order_id}/orderItems");

                $payload = $response->json();
                $order_items = $payload['payload']['OrderItems'];
                $order_items_array[] = $order_items;

                $item_total = $order_items[0]['ItemPrice']['Amount'];
                $item_price = $order_items[0]['ItemPrice']['Amount'] / $order_items[0]['QuantityOrdered'];

                // Getting error
                error_reporting(E_ALL);
                ini_set('display_errors', TRUE);

                foreach ($order_items as $order_item) {
                    // Prepare the request to get fees estimate
                    $feesEstimateRequest = [
                        'FeesEstimateRequest' => [
                            'MarketplaceId' => 'ATVPDKIKX0DER',
                            'IsAmazonFulfilled' => true,
                            'PriceToEstimateFees' => [
                                'ListingPrice' => [
                                    'CurrencyCode' => 'USD',
                                    'Amount' => $order_items[0]['ItemPrice']['Amount']
                                ]
                            ],
                            'Identifier' => '84058814556641'
                        ]
                    ];

                    // Make the request to get fees estimate for the SKU
                    $response = Http::withHeaders([
                        'x-amz-access-token' => $accessToken,
                        'Content-Type' => 'application/json'
                    ])->post("https://sellingpartnerapi-na.amazon.com/products/fees/v0/listings/{$order_items[0]['SellerSKU']}/feesEstimate", $feesEstimateRequest);

                    // Access the required fee information from the feesEstimate response variable
                    $feesEstimateResult = $response->json()['payload']['FeesEstimateResult'];

                    if (isset($feesEstimateResult['FeesEstimate'])) {

                        $feesEstimate = $response->json()['payload']['FeesEstimateResult']['FeesEstimate'];
                        $feeDetailList = $feesEstimate['FeeDetailList'];

                        foreach ($feeDetailList as $feeDetail) {
                            if ($feeDetail['FeeType'] === 'ReferralFee') {
                                $referralFeeAmount = $feeDetail['FeeAmount']['Amount'];
                            }
                        }
                    } else {
                        $referralFeeAmount = 0;
                    }

                    $profit = $item_total - $referralFeeAmount - $shipping_fee;

                    // // Cost Per Unit from Purchase
                    // $cost_per_unit = $this->getCostPerUnit($order_item['ASIN']);

                    $orders = new Order;
                    $orders->updateOrCreate(
                        ['order_id' => $item['AmazonOrderId']],
                        [
                            'order_status' => $item['OrderStatus'],
                            'order_date' => date("Y-m-d", strtotime($item['PurchaseDate'])),
                            'order_time' => date("H:i:s", strtotime($item['PurchaseDate'])),
                            'shipping_carrier' => $shipping_carrier,
                            'product_name' => $order_item['Title'],
                            'product_link' => "https://www.amazon.com/dp/" . $order_item['ASIN'],
                            'product_asin' => $order_item['ASIN'],
                            'sku' => $order_item['SellerSKU'],
                            'quantity' => $order_item['QuantityOrdered'],
                            'item_price' => $item_price,
                            'item_total' => $item_total,
                            'amazon_fee' => $referralFeeAmount,
                            'shipping_fee' => $shipping_fee,
                            'warehouse_fee' => $order_item['QuantityOrdered'],
                            'profit' => $profit,
                            // 'cost_per_unit' => $cost_per_unit
                        ]
                    );
                    sleep(2);
                }
            }
        }
        // $this->info('Data fetched and stored successfully.');
    }

    public function purchases()
    {
        // Fetch all data from the Purchase model
        $purchases = Purchase::paginate(10);
        // $orders = Order::all();
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        return view('pages.dashboards.purchases', ['purchases' => $purchases]);
    }

    public function showProductForm()
    {
        return view('pages.dashboards.createProduct');
    }

    public function createProduct(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'amazon_link' => 'required|url',
            'asin' => 'required|string|max:255',
            'total_purchased_units' => 'required|numeric|min:1',
            'cost_per_unit' => 'required|numeric',
        ]);

        Purchase::create([
            'date' => $request->date,
            'amazon_link' => $request->amazon_link,
            'asin' => $request->asin,
            'total_purchased_units' => $request->total_purchased_units,
            'cost_per_unit' => $request->cost_per_unit,
        ]);

        $cost_per_unit = $request->cost_per_unit;

        // Get all orders that match the given 'asin'
        $matchingOrders = Order::where('product_asin', $request->asin)->get();

        // Update each order's 'cost_per_unit' and calculate 'total_cost_per_unit' for each order
        foreach ($matchingOrders as $order) {
            // 'quantity' is from ORDERS table
            $quantity = $order->quantity;
            $cog = $cost_per_unit * $quantity;

            // updating 'cost_per_unit' and 'total_cost' fields in orders table
            $order->update([
                'cost_per_unit' => $cog,
            ]);
        }

        session()->flash('success', 'Data stored successfully!');

        return redirect()->route('dashboard.createProduct');
    }

    public function getOrderData()
    {
        // Fetch all data from the Order model
        $orders = Order::all();
        foreach ($orders as $order) {
            // Subtract 'cost_per_unit' from 'profit'
            $profit = $order->item_total - $order->warehouse_fee - $order->amazon_fee - $order->shipping_fee - $order->cost_per_unit;

            // Update the 'profit' field in the Order model
            $order->update([
                'profit' => $profit,
            ]);
        }
        $orders = Order::paginate(10);
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        return view('pages.dashboards.orders', ['orders' => $orders]);
    }
}
