<?php

namespace App\Http\Controllers\QAD  ;

use Illuminate\Http\Request;
use App\Models\QAD\Inventory;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\QAD\StandardWarehouseProduction;
use App\Models\QAD\StandardShipment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InventoryController extends Controller
{

    public function index()
    {
        $inventory = Inventory::all();
        return view('page.dataDashboard.inventory-index', compact('inventory'));
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

    public function getDashboardInventory()
    {
        $qxUrl = 'http://smii.qad:24079/wsa/smiiwsa';
        $timeout = 10;
        $domain = 'SMII';
        $qdocRequest = '
        <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
            <Body>
                <getDashboardInventory xmlns="urn:services-qad-com:smiiwsa:0001:smiiwsa">
                    <ip_domain>' . $domain . '</ip_domain>
                </getDashboardInventory>
            </Body>
        </Envelope>';

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
            return redirect()->back()->with('error', 'Gagal menghubungi server.');
        }

        if (!$qdocResponse) {
            return redirect()->back()->with('error', 'Tidak ada respons dari server.');
        }

        $xmlResp = simplexml_load_string($qdocResponse);
        $xmlResp->registerXPathNamespace('ns', 'urn:services-qad-com:smiiwsa:0001:smiiwsa');

        $qdocResult = (string) $xmlResp->xpath('//ns:getDashboardInventoryResponse/ns:opOk')[0];

        $inventoryItems = $xmlResp->xpath('//ns:getDashboardInventoryResponse/ns:ttTable/ns:ttTableRow');
        $jumlahItemBaru = 0;
        $jumlahItemUpdate = 0;

        if ($qdocResult == 'true') {
            foreach ($inventoryItems as $item) {
                $ld_part = (string) $item->ld_part;

                // Check if the item already exists
                $existingItem = Inventory::where('ld_part', $ld_part)->first();

                if ($existingItem) {
                    // If it exists, update the record
                    $existingItem->pt_desc1 = (string) $item->pt_desc1;
                    $existingItem->ld_status = (string) $item->ld_status;
                    $existingItem->ld_qty_oh = (string) $item->ld_qty_oh;
                    $existingItem->pt_um = (string) $item->pt_um;
                    $existingItem->ld_date = (string) $item->ld_date;
                    $existingItem->ld_loc = strtoupper((string) $item->ld_loc);
                    $existingItem->ld_lot = (string) $item->ld_lot;
                    $existingItem->aging_days = (int) $item->aging_days;
                    $existingItem->ld_expire = (string) $item->ld_expire;

                    $existingItem->save();
                    $jumlahItemUpdate++;
                } else {
                    // If it doesn't exist, create a new record
                    $newItem = new Inventory();
                    $newItem->ld_part = $ld_part;
                    $newItem->pt_desc1 = (string) $item->pt_desc1;
                    $newItem->ld_status = (string) $item->ld_status;
                    $newItem->ld_qty_oh = (string) $item->ld_qty_oh;
                    $newItem->pt_um = (string) $item->pt_um;
                    $newItem->ld_date = (string) $item->ld_date;
                    $newItem->ld_loc = strtoupper((string) $item->ld_loc);
                    $newItem->ld_lot = (string) $item->ld_lot;
                    $newItem->aging_days = (int) $item->aging_days;
                    $newItem->ld_expire = (string) $item->ld_expire;

                    $newItem->save();
                    $jumlahItemBaru++;
                }
            }
            Alert::success('Success', 'Data berhasil disimpan. Jumlah item baru: ' . $jumlahItemBaru . ', Jumlah item diperbarui: ' . $jumlahItemUpdate);
        } else {
            Alert::error('Error', 'Gagal mengambil data dari server.');
        }

        // Buat log dengan waktu perintah sudah diupdate atau di create
        Log::channel('inventory')->info('Perintah sudah diupdate atau di create pada: ' . now() . ' dengan jumlah item baru: ' . $jumlahItemBaru . ' dan jumlah item diperbarui: ' . $jumlahItemUpdate);

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

     public function dashboardWarehouse()
     {
        // $existingItem = Inventory::where('ld_part', $ld_part)->first();
        $warehouses = DB::table('standard_warehouse_productions')
               ->leftJoin('inventories', 'standard_warehouse_productions.rack', '=', DB::raw('LEFT(inventories.ld_loc, 3)'))
               ->select('standard_warehouse_productions.temperature as temperature', DB::raw('SUM(DISTINCT standard_warehouse_productions.pallet_rack) as pallet'), DB::raw('sum(ld_qty_oh) as quantity'), DB::raw('format(sum(ld_qty_oh)/sum(DISTINCT standard_warehouse_productions.pallet_rack)*100, 3)as percentage'))
               ->groupBy('standard_warehouse_productions.temperature')
               ->orderByRaw("
                    CASE
                        WHEN standard_warehouse_productions.temperature = 'Ambient' THEN 1
                        WHEN standard_warehouse_productions.temperature = '25 Degree' THEN 2
                        WHEN standard_warehouse_productions.temperature = '16 Degree' THEN 3
                        ELSE 4
                    END
                ")
               ->get();
         return \view('dashboard.dashboardWarehouse',['warehouses' => $warehouses]);
     }

     public function warehouseFilterData(Request $request){
        $date = $request->input('date');

        if (!$date) {
            return ['data' => []]; // Kembalikan array kosong jika tanggal tidak valid
        }

        $data = DB::table('standard_warehouse_productions')  
        ->whereDate('ld_date', $date)
        ->leftJoin('inventories', 'standard_warehouse_productions.rack', '=', DB::raw('LEFT(inventories.ld_loc, 3)'))
        ->select('standard_warehouse_productions.temperature as temperature', DB::raw('SUM(DISTINCT standard_warehouse_productions.pallet_rack) as pallet'), DB::raw('sum(ld_qty_oh) as quantity'), DB::raw('format(sum(ld_qty_oh)/sum(DISTINCT standard_warehouse_productions.pallet_rack)*100, 3)as percentage'))
        ->groupBy('standard_warehouse_productions.temperature')
        ->orderByRaw("
                CASE
                    WHEN standard_warehouse_productions.temperature = 'Ambient' THEN 1
                    WHEN standard_warehouse_productions.temperature = '25 Degree' THEN 2
                    WHEN standard_warehouse_productions.temperature = '16 Degree' THEN 3
                    ELSE 4
                END
            ")
        ->get(); // Pastikan ini mengembalikan koleksi

        // Kembalikan data sebagai array
        return ['data' => $data];
     }

    public function getAreaData(Request $request)
    {
        $month = $request->query('month');
        $year = $request->query('year');
        $currentMonth = Carbon::today()->month;
        $currentYear = Carbon::today()->year;

        $query = StandardShipment::query();

        if($year){
            $query->whereYear('date_shipment', $year);
        }else if(!$year){
            $query->whereYear('date_shipment', $currentYear);
            $year = $currentYear;
        }

        Log::info('Area Monthly Query: ' . $query->toSql());
        $areaDataMonthly = StandardShipment::query()->select(DB::raw("DATE_FORMAT(date_shipment, '%b') AS months, FORMAT(sum(ton), 3, 'id_ID') AS tons"))
        ->groupBy("months")
        ->whereYear('date_shipment', $year)
        ->orderBy('date_shipment','asc')
        ->get();
        

        if ($month){
            $query->whereMonth('date_shipment', $month);
        }else if (!$month){
            $query->whereMonth('date_shipment', $currentMonth);
        }

        $areaData = $query->select(DB::raw('DAY(date_shipment) AS days'), DB::raw("FORMAT(sum(ton), 3, 'id_ID') AS tons"))
            ->groupBy('date_shipment')
            ->orderBy('date_shipment','asc')
            ->get();
            

        // Log the query and the result
        Log::info('Area Data Query: ' . $query->toSql());
        Log::info('Area Data Result: ' . $areaData);

        return response()->json([
            'tons' =>  $areaData->pluck('tons'),
            'labels' => $areaData->pluck('days'),
            'monthlyTons' =>  $areaDataMonthly->pluck('tons'),
            'monthlyLabels' => $areaDataMonthly->pluck('months')
        ]);
    }

    public function warehouseAreaDispatch(Request $request){
        $date = $request->input('date');
        $month = $request->input('month');
        $year = $request->input('year');

        if (!$date) {
            return ['data' => []]; // Kembalikan array kosong jika tanggal tidak valid
        }

        $daily = DB::table('standard_shipments')
            ->select(DB::raw("FORMAT(sum(ton), 3, 'id_ID') AS tons"))
            ->whereDate('date_shipment', $date)
            ->groupBy('date_shipment')
            ->get();

        $monthly = DB::table('standard_shipments')
            ->select(DB::raw("FORMAT(sum(ton), 3, 'id_ID') AS tons"))
            ->whereMonth('date_shipment', $month)
            ->whereYear('date_shipment', $year)
            ->get();

        // Kembalikan data sebagai array
        return response()->json([
            'daily' =>  $daily,
            'monthly' => $monthly
        ]);
    }
}

