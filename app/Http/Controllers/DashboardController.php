<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Order;
use App\Models\UserProfit;
use App\Models\User;
use App\Models\Post;
use App\Models\ShippingFee;
use App\Models\Purchase;
use App\Models\ProfitList;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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

        $posts = Post::latest()->limit(6)->get();

        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        return view('pages.dashboards.client', compact('client', 'profitList', 'posts'));
    }

    public function fetchOrdersData(Request $request)
    {
        // Fetch the orders from the database
        $orders = Order::select('order_date', 'item_total', 'quantity')->get();

        // Prepare the aggregated data for each date
        $aggregatedData = [];
        foreach ($orders as $order) {
            $date = $order->order_date;
            $itemTotal = $order->item_total;
            $quantity = $order->quantity;

            // Combine item_total and quantity for the same date
            if (!isset($aggregatedData[$date])) {
                $aggregatedData[$date] = [
                    'itemTotal' => $itemTotal,
                    'quantity' => $quantity,
                ];
            } else {
                $aggregatedData[$date]['itemTotal'] += $itemTotal;
                $aggregatedData[$date]['quantity'] += $quantity;
            }
        }

        // Extract the order_dates, item_total, and quantity from the aggregated data
        $order_dates = array_keys($aggregatedData);
        $item_total = array_column($aggregatedData, 'itemTotal');
        $quantity = array_column($aggregatedData, 'quantity');

        // Prepare the response data
        $data = [
            'order_dates' => $order_dates,
            'item_total' => $item_total,
            'quantity' => $quantity,
        ];

        return response()->json($data);
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
        ini_set('max_execution_time', 5000);

        // get accessToken
        $response = Http::post('https://api.amazon.com/auth/o2/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => env('LWA_REFRESH_TOKEN'),
            'client_id' => env('LWA_CLIENT_ID'),
            'client_secret' => env('LWA_CLIENT_SECRET')
        ]);

        $accessToken = $response->json()['access_token'];

        // get OrderID
        function encodeURIComponent($str)
        {
            $revert = array('%21' => '!', '%2A' => '*', '%27' => "'", '%28' => '(', '%29' => ')');
            return strtr(rawurlencode($str), $revert);
        }

        $response = Http::withHeaders([
            'x-amz-access-token' => $accessToken,
        ])->get('https://sellingpartnerapi-na.amazon.com/orders/v0/orders', [
            'MarketplaceIds' => env('MARKET_PLACE_ID'),
            'CreatedAfter' => '2023-08-01'
        ]);

        $payload = $response->json();
        $orders_data = $payload['payload']['Orders'];

        while (isset($payload['payload']['NextToken'])) {
            $response = Http::withHeaders([
                'x-amz-access-token' => $accessToken
            ])->get('https://sellingpartnerapi-na.amazon.com/orders/v0/orders?MarketplaceIds=' . env('MARKET_PLACE_ID') . '&NextToken=' . encodeURIComponent($payload['payload']['NextToken']));

            // Decode the API response
            $payload = $response->json();

            // Merge the new orders data into the existing orders data
            $orders_data = array_merge($orders_data, $payload['payload']['Orders']);
        }

        $order_array = [];
        $order_items_array = [];

        foreach ($orders_data as $item) {
            if ($item['OrderStatus'] == 'Shipped') {
                $order_array[] = $item;

                $order_id = $item['AmazonOrderId'];
                $shipping_carrier = isset($item['AutomatedShippingSettings']['AutomatedCarrierName']) ? $item['AutomatedShippingSettings']['AutomatedCarrierName'] : '';

                // get data from OrderId
                $response = Http::withHeaders([
                    'x-amz-access-token' => $accessToken
                ])->get("https://sellingpartnerapi-na.amazon.com/orders/v0/orders/{$order_id}/orderItems");

                $payload = $response->json();
                $order_items = $payload['payload']['OrderItems'];
                $order_items_array[] = $order_items;

                // Getting error
                error_reporting(E_ALL);
                ini_set('display_errors', TRUE);

                foreach ($order_items as $order_item) {
                    $item_total = $order_item['ItemPrice']['Amount'];
                    $item_price = $order_item['ItemPrice']['Amount'] / $order_item['QuantityOrdered'];
                    // Prepare the request to get fees estimate
                    $feesEstimateRequest = [
                        'FeesEstimateRequest' => [
                            'MarketplaceId' => 'ATVPDKIKX0DER',
                            'IsAmazonFulfilled' => true,
                            'PriceToEstimateFees' => [
                                'ListingPrice' => [
                                    'CurrencyCode' => 'USD',
                                    'Amount' => $order_item['ItemPrice']['Amount']
                                ]
                            ],
                            'Identifier' => '84058814556641'
                        ]
                    ];

                    // Make the request to get fees estimate for the SKU
                    $response = Http::withHeaders([
                        'x-amz-access-token' => $accessToken,
                        'Content-Type' => 'application/json'
                    ])->post("https://sellingpartnerapi-na.amazon.com/products/fees/v0/listings/{$order_item['SellerSKU']}/feesEstimate", $feesEstimateRequest);

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

                    $orders = new Order;
                    $shipping_fee = Purchase::where('asin', $order_item['ASIN'])->value('shipping_fee');
                    $cost_per_unit = Purchase::where('asin', $order_item['ASIN'])->value('cost_per_unit');
                    $shipping_fee_value = $shipping_fee ?? 0;
                    $cost_per_unit_value = $cost_per_unit ?? 0;

                    $profit = $item_total - $referralFeeAmount - $shipping_fee_value - $cost_per_unit_value - $order_item['QuantityOrdered'];

                    $orders->updateOrCreate(
                        ['order_id' => $item['AmazonOrderId'], 'sku' => $order_item['SellerSKU']],
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
                            'shipping_fee' => $shipping_fee_value,
                            'cost_per_unit' => $cost_per_unit_value * $order_item['QuantityOrdered'],
                            'warehouse_fee' => $order_item['QuantityOrdered'],
                            'profit' => $profit,
                        ]
                    );
                    sleep(2);
                }
            }
        }
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
            'shipping_fee' => 'required|numeric',
            'cost_per_unit' => 'required|numeric',
            'image' => 'required|image',
        ]);

        // Store the image file in the local assets folder
        $imagePath = $request->file('image')->store('assets', 'public');

        $purchase = new Purchase;
        $purchase->date = $request->date;
        $purchase->amazon_link = $request->amazon_link;
        $purchase->asin = $request->asin;
        $purchase->total_purchased_units = $request->total_purchased_units;
        $purchase->shipping_fee = $request->shipping_fee;
        $purchase->cost_per_unit = $request->cost_per_unit;
        $purchase->image = Storage::url($imagePath);
        $purchase->save();

        $shipping_fee = $request->shipping_fee;
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
                'shipping_fee' => $shipping_fee
            ]);
        }

        session()->flash('success', 'Data stored successfully!');

        return redirect()->route('dashboard.createProduct');
    }

    public function showMonthlyReports()
    {
        $shipping_fees = ShippingFee::paginate(10);
        return view('pages.dashboards.monthlyReports', compact('shipping_fees'));
    }

    public function shippingFee(Request $request)
    {
        // Validate the form input fields
        $validatedData = $request->validate([
            'month_year' => 'required|date',
            'shipping_fee' => 'required|numeric',
        ]);

        // Format the month_year value
        $formattedMonthYear = Carbon::createFromFormat('Y-m', $validatedData['month_year'])->format('F Y');

        // Find the existing record by month_year
        $shippingFee = ShippingFee::where(
            'month_year',
            $formattedMonthYear
        )->first();

        if ($shippingFee) {
            // Update the shipping_fee value
            $shippingFee->shipping_fee = $validatedData['shipping_fee'];
            $shippingFee->save();
        } else {
            // Create a new shipping_fee record
            $shippingFee = new ShippingFee;
            $shippingFee->month_year = $formattedMonthYear;
            $shippingFee->shipping_fee = $validatedData['shipping_fee'];
            $shippingFee->save();
        }

        // Redirect or perform any other actions you need
        return redirect()->route('dashboard.monthlyReports');
    }

    public function monthlyReports()
    {
        $shipping_fees = ShippingFee::paginate(10);
        return view('pages.dashboards.monthlyReports', compact('shipping_fees'));
    }

    public function showAddPost()
    {
        return view('pages.dashboards.addPost');
    }

    public function showEditPost($id)
    {
        $post = Post::find($id);
        return view('pages.dashboards.editPost', compact('post'));
    }

    public function allPosts()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('pages.dashboards.allPosts', compact('posts'));
    }

    public function addPost(Request $request)
    {
        // Validate the form input fields
        $validatedData = $request->validate([
            'headline' => 'required',
            'category' => 'required',
            'content' => 'required',
            'image' => 'required|image',
        ]);

        // Store the image file in the local assets folder
        $imagePath = $request->file('image')->store('assets', 'public');

        // Create a new post record
        $post = new Post;
        $post->headline = $validatedData['headline'];
        $post->category = $validatedData['category'];
        $post->content = $validatedData['content'];
        $post->image = Storage::url($imagePath);
        $post->save();

        // Redirect or perform any other actions you need
        return redirect()->route('dashboard.addPost');
    }

    public function editPost(Request $request, $id)
    {
        // Find the post to be edited
        $post = Post::findOrFail($id);

        // Validate the form input fields
        $validatedData = $request->validate([
            'headline' => 'required',
            'category' => 'required',
            'content' => 'required',
            'image' => 'sometimes|image',
        ]);

        // Update the post fields if they are modified
        $post->headline = $validatedData['headline'];
        $post->category = $validatedData['category'];
        $post->content = $validatedData['content'];

        // Check if a new image was uploaded
        if ($request->hasFile('image')) {
            // Delete the previous image
            Storage::delete(public_path($post->image));

            // Store the new image in the local assets folder
            $imagePath = $request->file('image')->store('assets', 'public');
            $post->image = Storage::url($imagePath);
        }

        // Save the updated post
        $post->save();

        return redirect()->route('dashboard.allPosts');
    }

    public function deletePost($id)
    {
        // Find the post to be deleted
        $post = Post::findOrFail($id);

        // Delete the post image from storage
        Storage::delete(public_path($post->image));

        // Delete the post record from the database
        $post->delete();

        return redirect()->route('dashboard.allPosts');
    }

    public function getOrderData(Request $request)
    {
        $query = Order::query();

        // Retrieve the query parameters
        $queryParams = $request->except('page');
        $dateRequest = '';
        // Filter orders based on specific date range
        if ($request->has('date_range')) {
            $dateRequest = $request->input('date_range');
            $date_range = explode(' - ', $request->input('date_range'));
            $startDate = $date_range[0];
            $endDate = $date_range[1];

            $dateString = $startDate;
            $startDate = date('Y-m-d', strtotime(str_replace(' / ', '-', $dateString)));
            $dateString = $endDate;
            $endDate =  date('Y-m-d', strtotime(str_replace(' / ', '-', $dateString)));

            // Add the date range condition to the query
            $query->whereBetween('order_date', [$startDate, $endDate]);
        }

        // Sort orders based on order_date in descending order (most recent first)
        $sort = $request->input('sort');
        $direction = $request->input('direction', 'desc'); // Default to descending order
        if (
            $sort === 'order_date'
        ) {
            $query->orderBy('order_date', $direction);
        } else {
            // If no specific sorting is requested, sort by order_date in descending order by default
            $query->orderBy('order_date', 'desc');
        }

        // Fetch orders based on the filtered query
        $orders = $query->paginate(10);
        // Log::info("Logging query: " . $query);

        foreach ($orders as $order) {
            // Subtract 'cost_per_unit' from 'profit'
            $profit = $order->item_total - $order->warehouse_fee - $order->amazon_fee - $order->shipping_fee - $order->cost_per_unit;

            // Update the 'profit' field in the Order model
            $order->profit = $profit;

            // Save the updated order
            $order->save();
        }

        // Append the filter parameters to the pagination links
        $orders->appends($queryParams);

        // Add the vendors

        return view('pages.dashboards.orders', compact('orders', 'dateRequest'));
    }
}
