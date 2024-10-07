<?php

namespace App\Http\Controllers\QAD;

use App\Http\Controllers\Controller;
use App\Models\QAD\Production;
use App\Models\QAD\StandardProduction;
use App\Models\QAD\StandardWarehouseProduction;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class ProductionController extends Controller
{

    // =====================================================Production==============================================
    public function index()
    {
        $productions = Production::all();
        return view('page.dataDashboard.production-index', compact('productions'));
    }

    private function httpHeader($req)
    {
        return array(
            'Content-type: text/xml;charset="utf-8"',
            'Accept: text/xml',
            'Cache-Control: no-cache',
            'Pragma: no-cache',
            'SOAPAction: ""',        // jika tidak pakai SOAPAction, isinya harus ada tanda petik 2 --> ""
            'Content-length: ' . strlen(preg_replace("/\s+/", " ", $req))
        );
    }

    public function getProductions()
    {
        $qxUrl = 'http://smii.qad:24079/wsa/smiiwsa';
        $timeout = 10;
        $domain = 'SMII';
        $batchSize = 3000; // Ukuran batch
        $offset = 0;
        $totalNewItems = 0;
        $totalUpdatedItems = 0;
        $startdate = '2024-09-03';
        $enddate = date('Y-m-d');

        do {
            $qdocRequest =
                '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
                    <Body>
                        <getproduction xmlns="urn:services-qad-com:smiiwsa:0001:smiiwsa">
                            <ip_domain>' . $domain . '</ip_domain>
                            <ip_start_date>' . $startdate . '</ip_start_date>
                            <ip_end_date>' . $enddate . '</ip_end_date>
                            <ip_batch_size>'.$batchSize .'</ip_batch_size>
                            <ip_offset>'.$offset.'</ip_offset>
                        </getproduction>
                    </Body>
                </Envelope>';

            Log::channel('custom')->info('Mengirim request ke QAD', ['request' => $qdocRequest]);

            $curlOptions = array(
                CURLOPT_URL => $qxUrl,
                CURLOPT_CONNECTTIMEOUT => $timeout,
                CURLOPT_TIMEOUT => $timeout + 5,
                CURLOPT_HTTPHEADER => $this->httpHeader($qdocRequest),
                CURLOPT_POSTFIELDS => preg_replace("/\s+/", " ", $qdocRequest),
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false
            );

            $curl = curl_init();
            if ($curl) {
                curl_setopt_array($curl, $curlOptions);
                $qdocResponse = curl_exec($curl);
                curl_close($curl);
            } else {
                Log::channel('custom')->error('Gagal menghubungi server.');
                return redirect()->back()->with('error', 'Gagal menghubungi server.');
            }

            if (!$qdocResponse) {
                Log::channel('custom')->error('Tidak ada respons dari server.');
                return redirect()->back()->with('error', 'Tidak ada respons dari server.');
            }

            Log::channel('custom')->info('Menerima response dari QAD', ['response' => $qdocResponse]);

            $xmlResp = simplexml_load_string($qdocResponse);
            $xmlResp->registerXPathNamespace('ns', 'urn:services-qad-com:smiiwsa:0001:smiiwsa');

            $qdocResult = (string) $xmlResp->xpath('//ns:opOk')[0];

            $invoices = $xmlResp->xpath('//ns:getproductionResponse/ns:ttTrHistData/ns:ttTrHistDataRow');
            $jumlahItemBaru = 0;
            $jumlahItemUpdate = 0;

            if ($qdocResult == 'true') {
                foreach ($invoices as $item) {
                    $tr_trnbr = (string) $item->tr_trnbr;
                    $tr_nbr = (string) $item->tr_nbr;
                    $tr_effdate = (string) $item->tr_effdate;
                    $tr_type = (string) $item->tr_type;
                    $tr_prod_line = (string) $item->tr_prod_line;
                    $tr_part = (string) $item->tr_part;
                    $pt_desc1 = (string) $item->pt_desc1;
                    $tr_qty_loc = (string) $item->tr_qty_loc;
                    $Weight_in_KG = (string) $item->Weight_in_KG;
                    $Line = (string) $item->Line;
                    $pt_draw = (string) $item->pt_draw;
                    $shift	 = (string) $item->Shift;

                    $existingInvoice = Production::where('tr_trnbr', $tr_trnbr)->first();

                    if ($existingInvoice) {
                        $existingInvoice->tr_nbr = $tr_nbr;
                        $existingInvoice->tr_effdate = $tr_effdate;
                        $existingInvoice->tr_type = $tr_type;
                        $existingInvoice->tr_prod_line = $tr_prod_line;
                        $existingInvoice->tr_part = $tr_part;
                        $existingInvoice->pt_desc1 = $pt_desc1;
                        $existingInvoice->tr_qty_loc = floatval($tr_qty_loc);
                        $existingInvoice->Weight_in_KG = floatval($Weight_in_KG);
                        $existingInvoice->Line = $Line;
                        $existingInvoice->pt_draw = $pt_draw;
                        $existingInvoice->shift = $shift;

                        $existingInvoice->save();
                        $jumlahItemUpdate++;
                    } else {
                        $newInvoice = new Production();
                        $newInvoice->tr_trnbr = $tr_trnbr;
                        $newInvoice->tr_effdate = $tr_effdate;
                        $newInvoice->tr_nbr = $tr_nbr;
                        $newInvoice->tr_type = $tr_type;
                        $newInvoice->tr_prod_line = $tr_prod_line;
                        $newInvoice->tr_part = $tr_part;
                        $newInvoice->pt_desc1 = $pt_desc1;
                        $newInvoice->tr_qty_loc = floatval($tr_qty_loc);
                        $newInvoice->Weight_in_KG = floatval($Weight_in_KG);
                        $newInvoice->Line = $Line;
                        $newInvoice->pt_draw = $pt_draw;
                        $newInvoice->shift = $shift;
                        $newInvoice->save();
                        $jumlahItemBaru++;
                    }
                }
                $totalNewItems += $jumlahItemBaru;
                $totalUpdatedItems += $jumlahItemUpdate;
                Log::channel('custom')->info('Batch diproses', ['jumlahItemBaru' => $jumlahItemBaru, 'jumlahItemUpdate' => $jumlahItemUpdate]);
            } else {
                Log::channel('custom')->error('Gagal mengambil data dari server.');
                session(['toastMessage' => 'Gagal mengambil data dari server.', 'toastType' => 'error']);
                return redirect()->back();
            }

            $offset += $batchSize;
        } while (count($invoices) == $batchSize);

        session(['toastMessage' => 'Data berhasil disimpan. Jumlah item baru: ' . $totalNewItems . ', Jumlah item update: ' . $totalUpdatedItems, 'toastType' => 'success']);
        return redirect()->back();
    }

    // =============================================standardProduction==============================================

    public function standardProduction()
    {
        $standardProductions = StandardProduction::all();
        return \view('page.standard.production-index',\compact('standardProductions'));
    }

    public function storeStandardProductions(Request $request)
    {
        $standardProduction = new StandardProduction();
        $standardProduction->line = $request->line;
        $standardProduction->total = $request->total;
        $standardProduction->save();
        Alert::toast('Standard Production successfully added', 'success');
        return redirect()->back();
    }

    public function updateStandardProductions(Request $request, $id)
    {
        $standardProduction = StandardProduction::findOrFail($id);
        $standardProduction->line = $request->line;
        $standardProduction->total = $request->total;
        $standardProduction->save();
        Alert::toast('Standard Production successfully updated', 'success');
        return redirect()->back();
    }

    public function destroyStandardProductions($id)
    {
        $standardProduction = StandardProduction::findOrFail($id);
        $standardProduction->delete();
        Alert::toast('Standard Production successfully deleted', 'success');
        return redirect()->back();
    }

    // =========================================================StandardWarehouse=====================================================

    public function warehouseindex()
    {
        $standardWarehouse = StandardWarehouseProduction::all();
        return \view('page.standard.warehouse-index',\compact('standardWarehouse'));
    }

    public function warehousestore(Request $request)
    {
        $standardWarehouse = new StandardWarehouseProduction();
        $standardWarehouse->location = $request->location;
        $standardWarehouse->rack = $request->rack;
        $standardWarehouse->temperature = $request->temperature;
        $standardWarehouse->pallet_rack = $request->pallet_rack;
        $standardWarehouse->estimated_tonnage = $request->estimated_tonnage;
        $standardWarehouse->save();
        Alert::toast('Standard Warehouse Production successfully added', 'success');
        return redirect()->back();
    }

    public function warehouseupdate(Request $request, $id)
    {
        $standardWarehouse = StandardWarehouseProduction::findOrFail($id);
        $standardWarehouse->location = $request->location;
        $standardWarehouse->rack = $request->rack;
        $standardWarehouse->temperature = $request->temperature;
        $standardWarehouse->pallet_rack = $request->pallet_rack;
        $standardWarehouse->estimated_tonnage = $request->estimated_tonnage;
        $standardWarehouse->save();
        Alert::toast('Standard Warehouse Production successfully updated', 'success');
        return redirect()->back();
    }

    public function warehousedelete($id)
    {
        $standardWarehouse = StandardWarehouseProduction::findOrFail($id);
        $standardWarehouse->delete();
        Alert::toast('Standard Production successfully deleted', 'success');
        return redirect()->back();
    }


    // ============================================DataMonth=======================================================

    public function getProductionData(Request $request)
    {
        try {
            $month = $request->query('month');
            $week = $request->query('week');

            $query = DB::table('productions')
                ->select('Line', DB::raw('SUM(Weight_in_KG) as total_qty'), DB::raw('SUM(standard_total) as standard_total'))
                ->groupBy('Line');

            if ($month) {
                $query->whereMonth('tr_effdate', Carbon::parse($month)->month);
            }

            if ($week) {
                $startOfWeek = Carbon::now()->startOfMonth()->addWeeks($week - 1)->startOfWeek();
                $endOfWeek = $startOfWeek->copy()->endOfWeek();
                $query->whereBetween('tr_effdate', [$startOfWeek, $endOfWeek]);
            }

            $data = $query->get();

            return response()->json([
                'labels' => $data->pluck('tr_prod_line'),
                'actual' => $data->pluck('total_qty'),
                'standard' => $data->pluck('standard_total')
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function dashboardProduction(Request $request)
    {
        // Data untuk standar production gauge chart
        $gaugeStandarData = [
            'A' => StandardProduction::where('line', 'A')->sum('total'),
            'B' => StandardProduction::where('line', 'B')->sum('total'),
            'C' => StandardProduction::where('line', 'C')->sum('total'),
            'D' => StandardProduction::where('line', 'D')->sum('total'),
            'E' => StandardProduction::where('line', 'E')->sum('total')
        ];

        // Data untuk weight comparison
        $weightLastMonth = Production::whereMonth('tr_effdate', now()->subMonth()->month)->whereYear('tr_effdate', now()->year)->sum('Weight_in_KG');
        $weightThisMonth = Production::whereMonth('tr_effdate', now()->month)->whereYear('tr_effdate', now()->year)->sum('Weight_in_KG');
        $weightComparison = $this->getComparison($weightLastMonth, $weightThisMonth);

        // Data untuk quantity comparison
        $qtyLastMonth = Production::whereMonth('tr_effdate', now()->subMonth()->month)->whereYear('tr_effdate', now()->year)->sum('tr_qty_loc');
        $qtyThisMonth = Production::whereMonth('tr_effdate', now()->month)->whereYear('tr_effdate', now()->year)->sum('tr_qty_loc');
        $qtyComparison = $this->getComparison($qtyLastMonth, $qtyThisMonth);

        $weightLastMonth = number_format($weightLastMonth, 0, ',', '.');
        $qtyLastMonth = number_format($qtyLastMonth, 0, ',', '.');
        return response()->json(compact(
        'gaugeStandarData', 'weightLastMonth',
        'weightThisMonth', 'weightComparison', 'qtyLastMonth', 'qtyThisMonth',
        'qtyComparison'
        ));
    }

    private function getLineData($line)
    {
        
    }

    private function getComparison($lastMonth, $thisMonth)
    {
        if ($lastMonth == 0) {
            return 'N/A';
        }
        $difference = $thisMonth - $lastMonth;
        $percentage = number_format(($difference / $lastMonth) * 100, 3);
        return $percentage > 0 ? "Up by $percentage%" : "Down by $percentage%";
    }

    public function getBarData(Request $request)
    {
        $month = $request->query('month');
        $year = $request->query('year');
        $currentMonth = Carbon::today()->month;
        $currentYear = Carbon::today()->year;

        $query = Production::query();

        if ($year && $month){
            $query->whereYear('tr_effdate', $year);
            $query->whereMonth('tr_effdate', $month);
        }
        else if ($year && !$month){
            $query->whereYear('tr_effdate', $year);
            $query->whereMonth('tr_effdate', $currentMonth);
        }
        else if ($month && !$year) {
            $query->whereYear('tr_effdate', $currentYear);
            $query->whereMonth('tr_effdate', $month);
        } else {
            $query->whereYear('tr_effdate', $currentYear);
            $query->whereMonth('tr_effdate', $currentMonth);
        }

        // if ($month) {
        //     $query->whereMonth('tr_effdate', $month);
        // } else {
        //     $currentMonth = Carbon::today()->month;
        //     $query->whereMonth('tr_effdate', $currentMonth);
        // }

        $barData = $query->select('Line', DB::raw('SUM(Weight_in_KG) as total_qty'), DB::raw('DAY(tr_effdate) as day'))
            ->groupBy('tr_effdate', 'Line')
            ->orderBy('tr_effdate', 'asc')
            ->orderBy('line', 'asc')
            ->get();

        // Log the query and the result
        Log::info('Bar Data Query: ' . $query->toSql());
        Log::info('Bar Data Result: ' . $barData);

        $standardData = StandardProduction::select( DB::raw('SUM(total) as total'))->get();

        // Mengorganisir data actual_qty supaya bisa ditampilkan sesuai dengan hari
        $hashMap = [];
        $temp = ['A','B','C','D','E'];
        $count = 0;
        $sumHeight= 0; 
        $maxHeight = 0;
        foreach ($barData as $dataBar){
            $index = $count % 5;
            if($index==0){
                $maxHeight = max($sumHeight,$maxHeight);
                $sumHeight = 0;
            }
            if($temp[$index] != strtoupper($dataBar->Line)){
                $hashMap[$temp[$index]][] = 0;
                $count+=1;
            }
            
            $hashMap[strtoupper($dataBar->Line)][] = $dataBar->total_qty;
            $sumHeight += $dataBar->total_qty;
            $count+=1;
        }
        // Mengubah hashmap menjadi 2d array sesuai urutan
        $hashMap2 = [$hashMap['A'],$hashMap['B'],$hashMap['C'],$hashMap['D'],$hashMap['E']];

        return response()->json([
            'actual_height' => $maxHeight,
            'labels' => $barData->pluck('day'),
            'actual_qty' => $hashMap2,
            'standard_qty' => $standardData->pluck('total')
        ]);
    }

    private function getWeekDateRange($month, $week)
    {
        $year = now()->year;
        $start = null;
        $end = null;

        switch ($week) {
            case 1:
                $start = Carbon::create($year, $month, 1);
                $end = Carbon::create($year, $month, 7);
                break;
            case 2:
                $start = Carbon::create($year, $month, 8);
                $end = Carbon::create($year, $month, 14);
                break;
            case 3:
                $start = Carbon::create($year, $month, 15);
                $end = Carbon::create($year, $month, 21);
                break;
            case 4:
                $start = Carbon::create($year, $month, 22);
                $end = Carbon::create($year, $month, 28);
                break;
            case 5:
                $start = Carbon::create($year, $month, 29);
                $end = Carbon::create($year, $month, Carbon::create($year, $month)->endOfMonth()->day);
                break;
        }

        return [$start, $end];
    }

    private function getShiftData($line, $shift)
    {
        return Production::where('Line', $line)
            ->where('shift', $shift) // Pastikan ini sesuai dengan nilai di database
            ->whereDate('tr_effdate', Carbon::today())
            ->sum('Weight_in_KG');
    }

    public function filterData(Request $request)
    {
        $date = $request->input('date');

        if (!$date) {
            return ['data' => [], 'grandTotal' => 0]; // Kembalikan array kosong jika tanggal tidak valid
        }

        $data = Production::whereDate('tr_effdate', $date)
            ->select(DB::raw('upper(line) as line'), 'shift', DB::raw('SUM(Weight_in_KG) as total_weight'))
            ->groupBy('line', 'shift')
            ->get(); // Pastikan ini mengembalikan koleksi

        $grandTotal = $data->sum('total_weight');

        // Kembalikan data sebagai array
        return ['data' => $data, 'grandTotal' => $grandTotal];
    }

}
