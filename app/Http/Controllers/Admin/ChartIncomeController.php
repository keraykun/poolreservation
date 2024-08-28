<?php

// namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
// use App\Models\BookingsSummary;
// use Illuminate\Http\Request;
// use Illuminate\Support\Carbon;
// use ConsoleTVs\Charts\Facades\Charts;

// class IncomeController extends Controller
// {
//     public function index(Request $request)
//     {
//         $search = $request->search;
//         $currentDate = Carbon::now('Asia/Manila');
//         $incomes = $this->getIncomesByTimePeriod($search, $currentDate);

//         $monthName = ucfirst($search ?: 'all');
//         return view('admin.income.index', compact('incomes', 'monthName'));
//     }

//     public function chartData(Request $request)
//     {
//         $search = $request->search;
//         $currentDate = Carbon::now('Asia/Manila');
//         $incomes = $this->getIncomesByTimePeriod($search, $currentDate);

//         $chart = Charts::create('line', 'chartjs')
//             ->setTitle('Income Chart')
//             ->setLabels($incomes->pluck('date_at')->map(function ($date) {
//                 return date('M d, Y', strtotime($date));
//             })->toArray())
//             ->setDataset('Income', $incomes->pluck('partial'))
//             ->setResponsive(false);

//         return view('admin.income.chart', compact('chart', 'search'));
//     }

//     protected function getIncomesByTimePeriod($search, $currentDate)
//     {
//         switch ($search) {
//             case 'daily':
//                 return BookingsSummary::whereDate('date_at', $currentDate)
//                     ->orderBy('date_at', 'desc')->paginate(10);

//             case 'weekly':
//                 return BookingsSummary::whereBetween('date_at', [
//                     $currentDate->startOfWeek()->format('Y-m-d H:i:s'),
//                     $currentDate->endOfWeek()->format('Y-m-d H:i:s'),
//                 ])->orderBy('date_at', 'desc')->paginate(10);

//             case 'monthly':
//                 return BookingsSummary::whereMonth('date_at', $currentDate->month)
//                     ->orderBy('date_at', 'desc')->paginate(10);

//             default:
//                 return BookingsSummary::orderBy('date_at', 'desc')->paginate(10);
//         }
//     }
// }
