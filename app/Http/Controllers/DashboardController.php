<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Asset;
use App\Models\AssetHistory;
use App\Models\License;
use App\Models\Email;

class DashboardController extends Controller
{
    public function index()
    {
        // Asset statistics
        $totalAssets = Asset::count();
        $readyToDeploy = Asset::where('status', 'ready_to_deploy')->count();
        $deployed = Asset::where('status', 'deployed')->count();
        $archive = Asset::where('status', 'archive')->count();
        $broken = Asset::where('status', 'broken')->count();
        $inService = Asset::where('status', 'service')->count();
        $requestDisposal = Asset::where('status', 'request_disposal')->count();
        $disposed = Asset::where('status', 'disposed')->count();
        
        // Assets by department
        $assetsByDepartment = Asset::with('department')
            ->select('department_id')
            ->groupBy('department_id')
            ->with(['department' => function($q) {
                $q->select('id', 'name');
            }])
            ->get()
            ->groupBy('department_id')
            ->map(function($group) {
                return $group->count();
            });
        
        // Get all departments for better labeling
        $departmentCounts = \DB::table('assets')
            ->join('departments', 'assets.department_id', '=', 'departments.id')
            ->select('departments.name', \DB::raw('COUNT(assets.id) as count'))
            ->groupBy('departments.id', 'departments.name')
            ->orderBy('count', 'desc')
            ->get();
        
        // Monthly Asset Trends (assets added each month this year)
        $monthlyAssets = [];
        $monthlyBroken = [];
        
        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::create(Carbon::now()->year, $month, 1)->startOfMonth();
            $endDate = Carbon::create(Carbon::now()->year, $month, 1)->endOfMonth();
            
            // Count assets created in this month
            $assetsCount = Asset::whereBetween('created_at', [$startDate, $endDate])->count();
            $monthlyAssets[] = $assetsCount;
            
            // Count broken assets created in this month
            $brokenCount = Asset::where('status', 'broken')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
            $monthlyBroken[] = $brokenCount;
        }
        
        // Convert to JSON for JavaScript
        $monthlyAssetsTrend = json_encode($monthlyAssets);
        $monthlyBrokenTrend = json_encode($monthlyBroken);
        
        // License statistics
        $activeLicenses = License::where('status', 'active')->count();
        
        // Licenses expiring soon (status = expired_soon)
        $licensesExpiredSoon = License::where('status', 'expired_soon')->count();
        
        // Licenses already expired (status = inactive)
        $licensesExpired = License::where('status', 'inactive')->count();
        
        // Email statistics
        $totalEmails = Email::count();
        $activeEmails = Email::where('status', 'active')->count();
        $notUsedEmails = Email::where('status', 'not used')->count();
        $inactiveEmails = Email::where('status', 'inactive')->count();
        
        // Recent activities
        $recentActivities = AssetHistory::with(['user', 'asset'])
            ->latest()
            ->limit(10)
            ->get();
        
        // Recent assets (10 most recently updated)
        $recentAssets = Asset::latest('updated_at')
            ->limit(10)
            ->get();
        
        return view('dashboard.index', compact(
            'totalAssets',
            'deployed',
            'readyToDeploy',
            'archive',
            'broken',
            'inService',
            'requestDisposal',
            'disposed',
            'activeLicenses',
            'licensesExpiredSoon',
            'licensesExpired',
            'totalEmails',
            'activeEmails',
            'notUsedEmails',
            'inactiveEmails',
            'recentActivities',
            'recentAssets',
            'departmentCounts',
            'monthlyAssetsTrend',
            'monthlyBrokenTrend'
        ));
    }
    
    /**
     * Get licenses expiring soon as JSON
     */
    public function getLicensesExpiredSoon()
    {
        $licenses = License::where('status', 'expired_soon')
            ->orderBy('expiry_date', 'asc')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $licenses->map(function($license) {
                $days = $license->expiry_date ? Carbon::today()->diffInDays($license->expiry_date, false) : null;
                return [
                    'id' => $license->id,
                    'license_key' => $license->license_key,
                    'software' => $license->software_name ?? 'N/A',
                    'expiry_date' => $license->expiry_date?->format('Y-m-d'),
                    'days_until_expiry' => $days,
                ];
            }),
        ]);
    }
    
    /**
     * Get expired licenses as JSON
     */
    public function getLicensesExpired()
    {
        $licenses = License::where('status', 'inactive')
            ->orderBy('expiry_date', 'desc')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $licenses->map(function($license) {
                $days = $license->expiry_date ? Carbon::today()->diffInDays($license->expiry_date, false) : null;
                return [
                    'id' => $license->id,
                    'license_key' => $license->license_key,
                    'software' => $license->software_name ?? 'N/A',
                    'expiry_date' => $license->expiry_date?->format('Y-m-d'),
                    'days_since_expiry' => $days ? abs($days) : 0,
                ];
            }),
        ]);
    }
}
