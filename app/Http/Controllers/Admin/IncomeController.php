<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingsSummary;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $dailyChart = [];
        $weeklyChart = [];
        $monthlyChart = [];
        $values = [];
        if ($search) {

             $currentDate = Carbon::now('Asia/Manila');

            switch ($search) {
                case 'daily':
                    $incomes = BookingsSummary::whereDate('date_at', $currentDate)
                        ->orderBy('date_at', 'desc')->paginate(30);

                    $groupedIncomes = $incomes->groupBy(function ($item) {
                        return $item->date_at;
                    });

                    $mergedIncomes = $groupedIncomes->map(function ($group) {
                        $total = $group->sum('partial'); // Replace 'partial' with the actual column name you want to sum
                        return [
                            $group[0]->date_at=> $total,
                        ];
                    })->collapse()->toArray();

                      $dailyChart = collect($mergedIncomes)->values();
                      $values = collect($mergedIncomes)->keys();

                    break;

                case 'weekly':
                     $incomes = BookingsSummary::whereBetween('date_at', [
                        $currentDate->startOfWeek()->format('Y-m-d H:i:s'),
                        $currentDate->endOfWeek()->format('Y-m-d H:i:s'),
                    ])->orderBy('date_at', 'desc')->paginate(30);

                    $groupedIncomes = $incomes->groupBy(function ($item) {
                        return $item->date_at;
                    });

                    $mergedIncomes = $groupedIncomes->map(function ($group) {
                        $total = $group->sum('partial'); // Replace 'partial' with the actual column name you want to sum
                        return [
                            $group[0]->date_at=> $total,
                        ];
                    })->collapse()->toArray();

                     $weeklyChart = collect($mergedIncomes)->values();
                     $values = collect($mergedIncomes)->keys();

                    break;

                case 'monthly':
                    $incomes = BookingsSummary::whereMonth('date_at', $currentDate->month)
                        ->orderBy('date_at', 'desc')->paginate(30);

                    $groupedIncomes = $incomes->groupBy(function ($item) {
                        return $item->date_at;
                    });

                    $mergedIncomes = $groupedIncomes->map(function ($group) {
                        $total = $group->sum('partial'); // Replace 'partial' with the actual column name you want to sum
                        return [
                            $group[0]->date_at=> $total,
                        ];
                    })->collapse()->toArray();

                      $monthlyChart = collect($mergedIncomes)->values();
                      $values = collect($mergedIncomes)->keys();

                    break;
                case 'year':
                        $incomes = BookingsSummary::whereYear('date_at', $currentDate)
                            ->orderBy('date_at', 'desc')->paginate(30);
                        $groupedIncomes = $incomes->groupBy(function ($item) {
                            return $item->date_at;
                        });

                        $mergedIncomes = $groupedIncomes->map(function ($group) {
                            $total = $group->sum('partial'); // Replace 'partial' with the actual column name you want to sum
                            return [
                                $group[0]->date_at=> $total,
                            ];
                        })->collapse()->toArray();

                          $monthlyChart = collect($mergedIncomes)->values();
                          $values = collect($mergedIncomes)->keys();

                        break;

                default:
                    // Handle other cases or set a default behavior
                    $incomes = BookingsSummary::orderBy('created_at', 'desc')->paginate(30);
                    break;
            }

            $monthName = ucfirst($search);
        } else {
            $monthName = '';
            $incomes = BookingsSummary::orderBy('created_at', 'desc')->paginate(30);
        }

        //return $monthlyChart;
       // return $values;

        return view('admin.income.index', [
            'incomes' => $incomes,
            'search' => $monthName,
            'dailychart'=>$dailyChart,
            'weeklychart'=>$weeklyChart,
            'monthlychart'=>$monthlyChart,
            'values'=>$values
        ]);
    }

    public function chart(Request $request)
    {
        $search = $request->search;

        if ($search) {
            $currentDate = Carbon::now('Asia/Manila');

            switch ($search) {
                case 'daily':
                    $incomes = BookingsSummary::whereDate('date_at', $currentDate)
                        ->orderBy('date_at', 'desc')->paginate(30);
                    break;

                case 'weekly':
                    $incomes = BookingsSummary::whereBetween('date_at', [
                        $currentDate->startOfWeek()->format('Y-m-d H:i:s'),
                        $currentDate->endOfWeek()->format('Y-m-d H:i:s'),
                    ])->orderBy('date_at', 'desc')->paginate(30);

                    break;

                case 'monthly':
                    $incomes = BookingsSummary::whereMonth('date_at', $currentDate->month)
                        ->orderBy('date_at', 'desc')->paginate(30);
                    break;

                default:
                    // Handle other cases or set a default behavior
                    $incomes = BookingsSummary::orderBy('created_at', 'desc')->paginate(30);
                    break;
            }

            $monthName = ucfirst($search);
        } else {
            $monthName = '';
            $incomes = BookingsSummary::orderBy('created_at', 'desc')->paginate(30);
        }

        return view('admin.income.chart', ['incomes' => $incomes, 'search' => $monthName]);
    }
}
