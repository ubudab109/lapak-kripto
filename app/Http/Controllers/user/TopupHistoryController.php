<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\TopupTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class TopupHistoryController extends Controller
{
    /**
     * Virtual Account History
     */
    public function vaHistory(Request $request)
    {
        if ($request->ajax()) {
            $transactions = TopupTransaction::where('payment_type',XENDIT)->where('payment_channels', VA_CHANNELS)->where('user_id', Auth::id());

            if ($request->has('status') && $request->status != '') {
                if ($request->status == 'EXPIRED') {
                    $transactions->where('expired_at','<',Carbon::now())->where('status','ACTIVE');
                } else {
                    $transactions->where('status', $request->status);
                }
            }
            $data = $transactions->orderBy('created_at','desc')->get();

            return datatables($data)
            ->addColumn('action', function($row) {
                $html = "<button class='btn btn-primary' onclick='showVa(".$row->id.")' data-toggle='modal' data-target='#invoice-va'>Detail</button>";
                return $html;
            })
            ->editColumn('status', function($row) {
                if ($row->status == 'COMPLETED') {
                    $html = "<span class='badge badge-success'>Completed</span>";
                } else {
                    if ($row->expired_at < Date::now()) {
                        $html = "<span class='badge badge-danger'>Expired</span>";
                    } else if ($row->status == 'ACTIVE') {
                        $html = "<span class='badge badge-info'>Active</span>";
                    } else if ($row->status == 'PENDING') {
                        $html = "<span class='badge badge-warning'>Pending</span>";
                    }
                }

                return $html;
            })
            ->editColumn('expired_at', function ($item) {
                return $item->expired_at ? with(new Carbon($item->expired_at))->format('d M Y h:i:s') : '';
            })
            ->rawColumns(['action','status','expired_at'])
            ->make(true);
        }
    }

    /**
     * Detail Transaction Topup VA
     * TransactionHistory $id
     */
    public function showTopupHistory($id) 
    {
        $topupData = TopupTransaction::with('user')->find($id);

        return response()->json($topupData, 200);
    }

    /**
     * Virtual Account History
     */
    public function eWalletHistory(Request $request)
    {
        if ($request->ajax()) {
            $transactions = TopupTransaction::oldest()->where('payment_type',XENDIT)->where('payment_channels', EWALLET_CHANNELS)->where('user_id', Auth::id());

            if ($request->has('status') && $request->status != '') {
                $transactions->where('status', $request->status);
            }
            $data = $transactions->get();

            return datatables($data)
            ->addColumn('action', function($row) {
                $html = "<button class='btn btn-primary' onclick='showEwallet(".$row->id.")' data-toggle='modal' data-target='#invoice-ewallet'>Detail</button>";
                return $html;
            })
            ->editColumn('status', function($row) {
                if ($row->status == 'SUCCEEDED') {
                    $html = "<span class='badge badge-success'>Success</span>";
                } else if ($row->status == 'PENDING') {
                    $html = "<span class='badge badge-warning'>Pending</span>";
                } else if ($row->status == 'FAILED') {
                    $html = "<span class='badge badge-danger'>Failed</span>";
                }
                return $html;
            })
            ->editColumn('updated_at', function ($item) {
                return $item->updated_at ? with(new Carbon($item->updated_at))->format('d M Y h:i:s') : '';
            })
            ->rawColumns(['action','status','updated_at'])
            ->make(true);
        }
    }

    /**
     * Retail History
     */
    public function retailHistory(Request $request)
    {
        if ($request->ajax()) {
            $transactions = TopupTransaction::oldest()->where('payment_type',XENDIT)->where('payment_channels', RETAIL_CHANNELS)->where('user_id', Auth::id());

            if ($request->has('status') && $request->status != '') {
                if ($request->status == 'EXPIRED') {
                    $transactions->where('expired_at','<',Carbon::now())->where('status','ACTIVE');
                } else {
                    $transactions->where('status', $request->status);
                }
            }
            $data = $transactions->get();

            return datatables($data)
            ->addColumn('action', function($row) {
                $html = "<button class='btn btn-primary' onclick='showRetail(".$row->id.")' data-toggle='modal' data-target='#invoice-ewallet'>Detail</button>";
                return $html;
            })
            ->editColumn('status', function($row) {
                if ($row->status == 'COMPLETED') {
                    $html = "<span class='badge badge-success'>Completed</span>";
                } else {
                    if ($row->expired_at < Date::now()) {
                        $html = "<span class='badge badge-danger'>Expired</span>";
                    } else if ($row->status == 'ACTIVE') {
                        $html = "<span class='badge badge-info'>Active</span>";
                    } else if ($row->status == 'PENDING') {
                        $html = "<span class='badge badge-warning'>Pending</span>";
                    } else if ($row->status == 'INACTIVE') {
                        $html = "<span class='badge badge-secondary'>Inactive</span>";
                    } else if ($row->status == 'SETTLING') {
                        $html = "<span class='badge badge-light'>In Process</span>";
                    }
                }
                return $html;
            })
            ->editColumn('expired_at', function ($item) {
                return $item->expired_at ? with(new Carbon($item->expired_at))->format('d M Y h:i:s') : '';
            })
            ->editColumn('updated_at', function ($item) {
                return $item->updated_at ? with(new Carbon($item->updated_at))->format('d M Y h:i:s') : '';
            })
            ->rawColumns(['action','status','updated_at','expired_at'])
            ->make(true);
        }
    }


    /**
     * Retail History
     */
    public function qrisHistory(Request $request)
    {
        if ($request->ajax()) {
            $transactions = TopupTransaction::oldest()->where('payment_type',XENDIT)->where('payment_channels', QRIS_CHANNELS)->where('user_id', Auth::id());

            if ($request->has('status') && $request->status != '') {
                $transactions->where('status', $request->status);
            }
            $data = $transactions->get();

            return datatables($data)
            ->addColumn('action', function($row) {
                $html = "<button class='btn btn-primary' onclick='showQris(".$row->id.")' data-toggle='modal' data-target='#invoice-qris'>Detail</button>";
                return $html;
            })
            ->editColumn('status', function($row) {
                if ($row->status == 'ACTIVE') {
                    $html = "<span class='badge badge-info'>Active</span>";
                } else if ($row->status == 'PENDING') {
                    $html = "<span class='badge badge-warning'>Pending</span>";
                } else if ($row->status == 'INACTIVE') {
                    $html = "<span class='badge badge-secondary'>Inactive</span>";
                } else if ($row->status == 'COMPLETED') {
                    $html = "<span class='badge badge-success'>Completed</span>";
                } else if ($row->status == 'FAILED') {
                    $html = "<span class='badge badge-danger'>Failed</span>";
                }
                return $html;
            })
            ->rawColumns(['action','status','updated_at','expired_at'])
            ->make(true);
        }
    }


    /**
     * Retail History
     */
    public function bankDepoHistory(Request $request)
    {
        if ($request->ajax()) {
            $transactions = TopupTransaction::oldest()->where('payment_type',BANK_DEPOSIT)->where('user_id', Auth::id());
            
            if ($request->has('status') && $request->status != '') {
                $transactions->where('status', $request->status);
            }

            $data = $transactions->get();

            return datatables($data)
            ->addColumn('action', function($row) {
                $html = "<button class='btn btn-primary' onclick='showBank(".$row->id.")' data-toggle='modal' data-target='#invoice-bank'>Detail</button>";
                return $html;
            })
            ->editColumn('idr', function($row) {
                return 'Rp. '. number_format($row->total_topup, 0);
            })
            ->editColumn('dollar', function($row) {
                return number_format($row->dollar_topup, 0).' $';
            })
            ->editColumn('status', function($row) {
                if ($row->status == 'PENDING') {
                    $html = "<span class='badge badge-warning'>Pending</span>";
                } else if ($row->status == 'COMPLETED') {
                    $html = "<span class='badge badge-success'>Completed</span>";
                } else if ($row->status == 'FAILED') {
                    $html = "<span class='badge badge-danger'>Failed</span>";
                }
                return $html;
            })
            ->rawColumns(['action','status'])
            ->make(true);
        }
    }
}
