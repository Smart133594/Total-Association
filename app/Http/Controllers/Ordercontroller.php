<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Orderdetails;
use App\Models\Delivery;
use Auth;

class Ordercontroller extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 7) {
            $deliveryboy = Delivery::where('retailerId',Auth::id())->get();
            $order = Order::where('status', 1)->where('retailerId',Auth::id())->get();
        } else {
            $deliveryboy = Delivery::get();
            $order = Order::where('status', 1)->get();
        }


        return view('admin.order.index', ['order' => $order, 'deliveryboy' => $deliveryboy]);
    }

    public function track($id)
    {
        $order = Order::where('id', $id)->first();
        $track = json_decode($order->trackingDetails, true);
        // dd($track);
        return view('admin.order.track', ['order' => $order, 'track' => $track]);
    }

    public function details($id)
    {
        $current_order = Order::where('id', $id)->first();

        $order = Orderdetails::where('orderId', $id)->get();
        return view('admin.order.details', ['order' => $order, 'current_order' => $current_order]);
    }

    public function updateorder(Request $request)
    {
        $order = Order::find($request->id);
        $order->orderStatus = $request->orderStatus;
        if (!empty($request->track)) {
            $track = $order->trackingDetails;
            $track = json_decode($track, true);
            $date = date('d M, Y h:i');
            $newtrack['time'] = $date;
            $newtrack['data'] = $request->track;
            $track[] = $newtrack;
            $track = json_encode($track);
            $order->trackingDetails = $track;
        }
        $order->save();
        return redirect("/order");
    }

    public function updatedeliveryperson(Request $request)
    {
        $order = Order::find($request->id);
        $order->deliverypersonId = $request->deliverypersonId;
        $order->save();
        return redirect("/order");
    }


}
