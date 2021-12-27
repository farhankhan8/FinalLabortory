<?php
namespace App\Http\Controllers;
use App\Models\AvailableTest;
use App\Models\TestPerformed;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
class SalesController extends Controller
{
    public function index()
    {  
        $todayDate = Carbon::today();
        $yesterDay = Carbon::yesterday();
     
        $cuentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $beforeTwoDaySales = Carbon::now()->subDays(2);
        $beforeThreeDaySales = Carbon::now()->subDays(3);
        $beforeFourDaySales = Carbon::now()->subDays(4);

        $todaySalesForTable = TestPerformed::whereDate('created_at', '=',$todayDate)->pluck('fee')->sum();
        $yesterDaySum = TestPerformed::whereDate('created_at', '=',$yesterDay)->pluck('fee')->sum();
        $todaySales = TestPerformed::whereDate('created_at', '=', $todayDate)->pluck('fee')->sum();
        $previousDaySales = TestPerformed::whereDate('created_at', '=', $beforeThreeDaySales)->pluck('fee')->sum();
        $previousFourDaySales = TestPerformed::whereDate('created_at', '=', $beforeFourDaySales)->pluck('fee')->sum();
        $previousTwoDaySales = TestPerformed::whereDate('created_at', '=', $beforeTwoDaySales)->pluck('fee')->sum();

        $thisWeekSeles = TestPerformed::whereDate('created_at', '>',Carbon::now()->subDays(7))->pluck('fee')->sum();
        $thisMongthSales = TestPerformed::whereDate('created_at', '>=',$cuentMonth)->pluck('fee')->sum();
        $thisYearSales = TestPerformed::whereDate('created_at', '>=',$currentYear)->pluck('fee')->sum();

        $salesForSenvenDays = AvailableTest::withSum('testPerformed','fee')->whereDate('created_at', '>',
        Carbon::now()->subDays(7))->latest()->get();
        $salesForThirtyDays = AvailableTest::withSum('testPerformed','fee')->whereDate('created_at', '>=',
        $cuentMonth)->take(30)->latest()->get();

        return view('sales', compact('todaySales','thisWeekSeles','thisMongthSales','thisYearSales',
        'todaySalesForTable','todayDate','yesterDaySum','yesterDay','salesForSenvenDays','salesForThirtyDays',
        'previousDaySales','beforeThreeDaySales','previousTwoDaySales','beforeTwoDaySales'));
        
    }
   
}