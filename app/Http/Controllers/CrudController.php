<?php

namespace App\Http\Controllers;

use App\Interfaces\CrudInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Bank;
use App\Models\Region;
use App\Models\BankBranch;
use Maatwebsite\Excel\Facades\Excel;

class CrudController extends Controller
{

    private string $_class;
    private object $_dummy;
    private array $_filters = [];
    private array $_searchables = [];

    /**
     * Display a listing of the resource.
     *
     * @param  string  $class
     * @return \Illuminate\Http\Response
     */
    public function index(string $class)
    {
        // dd('das');
        if ($response = $this->init($class, '', ' List')) {
            return $response;
        }

        $query = call_user_func([$this->_class, 'query']);

        foreach(request()->all() as $column => $value) {
            $value = trim($value);
            if($value) {
                if(substr($column, 0, 7) == 'filter_') {
                    $query->where(substr($column, 7), $value);
                } else if($column =='search') {
                    $query->where(fn($q) => array_walk($this->_searchables, fn($col) => $q->orWhere($col, 'like', "%$value%")));
                }
            }
        }

        $items = $query->paginate(10);
        return view('crud.index', ['models' => $items->all(), 'links' => $items->withQueryString()->links(), 'controller' => $this]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  string  $class
     * @return \Illuminate\Http\Response
     */
    public function create(string $class)
    {
        if ($response = $this->init($class, 'New ')) {
            return $response;
        }
        return view('crud.form', ['model' => $this->_dummy]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  string  $class
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(string $class, Request $request)
    {
        if ($response = $this->init($class)) {
            return $response;
        }
        $className = $this->_class;
        $model = new $className();
        $data = $request->validate($this->_dummy->getRequestValidator());
        // dd($request->hasFile('image'));
        
        // Handle image upload for the Banner model
        if ($model instanceof \App\Models\Banner) {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('banner_images', 'public');
                // dd($imagePath);
                $data['image'] = $imagePath;
                
            }if($request->hasFile('cm_image')){
                $request->validate([
                    'cm_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
                ]);
                $cm_imagePath = $request->file('cm_image')->store('banner_images', 'public');
                $data['cm_image'] = $cm_imagePath;
            }if($request->hasFile('minister_image')){
                $request->validate([
                    'minister_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
                ]);
                $minister_imagePath = $request->file('minister_image')->store('banner_images', 'public');
                $data['minister_image'] = $minister_imagePath;
            }
        }if ($model instanceof \App\Models\Dlcmeeting){
            $imagePath = $request->file('image')->store('dcl_meeting', 'public');
                // dd($imagePath);
                $data['image'] = $imagePath;
        }
        if ($model instanceof \App\Models\Successstories){
            $imagePath = $request->file('file')->store('success_story', 'public');
                // dd($imagePath);
                $data['file'] = $imagePath;
        }
        if ($model instanceof \App\Models\Homenotifications){
            $pdfPath = $request->file('file')->store('noti_pdf', 'public');
                // dd($imagePath);
                $data['file'] = $pdfPath;
        }
    
        $model->fill($data);
        $model->save();
        return redirect()->route('crud.edit', ['class' => $class, 'id' => $model->id])->with('success', 'Record has been created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string   $class
     * @param  int      $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $class, int $id)
    {
        if ($response = $this->init($class, 'Edit ')) {
            return $response;
        }

        $model = call_user_func_array([$this->_class, 'findOrFail'], [$id]);
        if (!is_a($model, CrudInterface::class)) {
            return redirect()->route('crud.list', $class)->with('error', 'This models is not editable!');
        }

        return view('crud.form', ['model' => $model]);
    }

    public function bulkUpload()
    {
        return view('crud.bulk-upload');
    }
    public function processUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        $file = $request->file('file');

        $data = Excel::toArray([], $file)[0];

        // Uncomment this to find the missing bank in new excel
        // foreach ($data as $index => $row) {
        //     // Skip the header row
        //     if ($index === 0) {
        //         continue;
        //     }
        //     // Check if the 'BANK NAME' key exists in the row
        //     if (isset($row[3])) {
        //         $bankNameInExcel = $row[3];

        //         $matchingBank = $this->fuzzySearchBank($bankNameInExcel);
        //     } else {
        //         echo "BANK NAME key not found in row $index.";
        //     }
        // }
        foreach ($data as $index => $row) {
            if ($index === 0) {
                continue;
            }
            // Extracting data from the Excel row
            $ifscCode = $row[0];
            $bankName = $row[3];
            $branchName = $row[4];
            $districtName = $row[7];
            $address = $row[6];
            $cityName = $row[5];
            $micrCode = $row[2];
            $stdCode = $row[9];
            $phoneNumber = $row[10];
            $neftEnabled = $row[11];
            $rtgsEnabled = $row[12];
            $lcsEnabled = $row[13];
            $bgsEnabled = $row[14];
    
            // Search or create the bank
            $bank = $this->fuzzySearchBank($bankName);
    
            if (!$bank) {
                continue;
            }
    
            // Search or create the district
            $district = Region::where('name', $districtName)->where('type_id', 404)->first();
            if (!$district) {
                dd('District Name Not Fount' . $districtName . "Please correct in Excel and try again!");
                continue;
            }else{

            }
    
            // Create or update the bank branch
            $bankBranch = BankBranch::updateOrCreate(
                ['ifsc' => $ifscCode],
                [
                    'address' => $address,
                    'bank_id' => $bank->id,
                    'bgs_enabled' => $bgsEnabled,
                    'city_name' => $cityName,
                    'created_by' => 0,
                    'district_id' => $district->id,
                    'lcs_enabled' => $lcsEnabled,
                    'micr_code' => $micrCode,
                    'name' => $branchName,
                    'neft_enabled' => $neftEnabled,
                    'phone_number' => $phoneNumber,
                    'rtgs_enabled' => $rtgsEnabled,
                    'std_code' => 0,
                ]
            );
        }
        return redirect()->back()->with('success', 'Data uploaded and updated successfully.');
    }
    private function fuzzySearchBank($bankNameInExcel)
    {
        $matchingBank = Bank::whereRaw('LOWER(name) = ?', [strtolower($bankNameInExcel)])->first();
        if($matchingBank){
            return $matchingBank;
        }else{
            echo $bankNameInExcel . "Not found in DB please correct the name in DB or Add" ."<br>";
            return null;
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  string  $class
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(string $class, int $id, Request $request)
    {
        if ($response = $this->init($class, ' Edit')) {
            return $response;
        }
        $model = call_user_func_array([$this->_class, 'findOrFail'], [$id]);
        $model->fill($request->validate($this->_dummy->getRequestValidator()));
        $model->save();
        return redirect()->back()->with('success', 'Record has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string   $class
     * @param  int      $id
     * @return \Illuminate\Http\Response
     */
    public function delete(string $class, int $id)
    {
        //
    }

    private function init(string $class, string $prefix = '', string $suffix = '')
    {   
        $title = str_replace('-', ' ', Str::title($class));
        $this->setTitle($prefix . $title . $suffix);
        $this->_vars['class'] = $class;
        $this->_vars['modelName'] = $title;
        $this->_class = 'App\\Models\\' . str_replace(' ', '', $title);
        
        if (!class_exists($this->_class)) {
            return redirect()->route('dashboard')->with('error', "Unknown model '{$this->_class}' requested!");
        }
        
        if (!in_array(CrudInterface::class, class_implements($this->_class))) {
            return redirect()->route('dashboard')->with('error', "Model class does not extends CRUD interface!");
        }
        // dd('tite',$this->_class);
        $className = $this->_class;

        $this->_dummy = new $className();

        $validator = $this->_dummy->getRequestValidator();
        $this->_dummy->filter = request()->get('filter');
        foreach($validator as $column => $rules) {
            $rules = [...array_filter(explode('|', $rules), fn($r) => substr($r, 0, 7) == 'exists:')];
            if (empty($rules)) {
                $this->_searchables[] = $column;
            } else {
                $this->_filters[] = $column;
                $this->_dummy->{'filter_' . $column} = request()->get('filter_' . $column);
            }
        }
        return null;
    }

    public function displayModelColumn($model, $column)
    {
        $validator = $this->_dummy->getRequestValidator();
        if (isset($validator[$column])) {
            $rules = [...array_filter(explode('|', $validator[$column]), fn($r) => substr($r, 0, 7) == 'exists:')];
            if (!empty($rules)) {
                $record = call_user_func_array([explode(',', substr($rules[0], 7))[0], 'find'], [$model->$column]);
                if ($record && isset($record->name)) {
                    return $record->name;
                } elseif($record && isset($record->title)) {
                    return $record->title;
                }else{
                    return $model->$column;
                }
            }
        }
        return $model->$column;
    }

    public function displayHeader($column) {
        if(substr($column, -3) == '_id') {
            $column = substr($column, 0, -3);
        }
        return str(str_replace('_', ' ', $column))->title();
    }

    public function getFilters():array {
        return $this->_filters;
    }

    public function getDummy():object {
        return $this->_dummy;
    }

    public function getFilterElement($column):object|null {
        foreach($this->_dummy->getFormDesign() as $element) {
            if($element->attributes->name == $column) {
                if(property_exists($element->attributes, 'required')) {
                    unset($element->attributes->required);
                }
                $element->attributes->name = 'filter_' . $element->attributes->name;
                $element->width = 3;
                $element->helpText = '';
                $element->helpHtml = '';
                $element->showChoose = true;
                return $element;
            }
        }
        return null;
    }
}
