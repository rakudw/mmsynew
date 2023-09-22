@extends('layouts.admin')

@section('title', $title ?? 'Application for Approval')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none"
                    href="{{ route('applications.list') }}">{{ __('Applications') }}</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                {{ $title ?? __('Application for Approval') }}</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">{{ $title ?? __('Application for Approval') }}</h6>
    </nav>
@endsection

@section('content')
    
    <!-- @if (!$application->id) -->
        <div class="row" id="instructions">
            <div class="col-12">
                <div class="card">
                    <div class="card-header custom">
                        <h4>Instructions and Declaration</h4>
                        <a href="{{ route("login") }}"><button class="btn btn-success">Login To Existing Application</button></a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">By clicking the button below you agree to the following:</h5>
                        <ul class="list-group">
                            <li class="list-group-item">&bull; The applicant is a <abbr
                                    title="Bonafide certificate is certification provided to the citizen by the government confirming and testifying their place of residence in the district of Himachal Pradesh.">Bonafied
                                    Himachali</abbr>.</li>
                            <li class="list-group-item">&bull; The age of the applicant is as per the policy requirements.
                            </li>
                            <li class="list-group-item">&bull; The applicant and their spouse have not taken the benefit of
                                this scheme yet.</li>
                            <li class="list-group-item">&bull; The applicant has read the policy document thoroughly.</li>
                            <li class="list-group-item">* <small>The applicant above refers to all the partners/shareholders
                                    collectively or the individual in case of a proprietorship.</small></li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary"
                            onclick="javascript:document.getElementById('formHolder').classList.remove('d-none');document.getElementById('instructions').classList.add('d-none');document.querySelector('input[type=text]').focus();">
                            Continue With New Application</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- @endif -->

    <div class="row {{ $application->id ? '' : 'd-none' }}" id="formHolder">
        <div class="col-12">
            <x-forms.form />
        </div>
    </div>
@endsection

<style>
    aside{
        display: none
    }
    /*Generated from Designmycss.com*/
    .button {  
        /* Fix to remove extra padding in IE */
        width: auto; 
        overflow: visible;
        /* End */
        /* Fix for disappearing labels in IE7 - Thanks to Tom Gibara */
        filter: Alpha(Opacity=100);
        /* End */ 
        cursor: pointer;
        height: 30px;
        padding: 0 7px;
        margin: 0;	
        border: 1px solid;
        border-color: #bbb #777 #777 #bbb; 
        color: #000;
        text-transform: capitalize;		
        text-shadow: 0 1px 1px rgba(255,255,255,0.75);	
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;	
        -webkit-box-shadow: 1px 1px 1px rgba(0,0,0,0.25);
        -moz-box-shadow: 1px 1px 1px rgba(0,0,0,0.25);
        box-shadow: 1px 1px 1px rgba(0,0,0,0.25);
        background: #ccc;		
        background: -moz-linear-gradient(100% 100% 90deg, #aaa, #ccc);
        background: -webkit-gradient(linear, left top, left bottom, from(#ccc), to(#aaa));	
    }
    /* Fix padding and text alignment in firefox */
    .button::-moz-focus-inner { 
        padding: 0;
        border: 0;
    }
    /* Hover and focus states for mouse-over and tab focus */
    .button:hover,
    .button:focus {
        border-color: #aaa #555 #555 #aaa;
        color: #000;
        text-shadow: 0 1px 1px rgba(255,255,255,0.75);
        background: #bbb;
        background: -moz-linear-gradient(100% 100% 90deg, #888, #bbb);
        background: -webkit-gradient(linear, left top, left bottom, from(#bbb), to(#888));
        -webkit-box-shadow: 1px 1px 1px rgba(0,0,0,0.5);
        -moz-box-shadow: 1px 1px 1px rgba(0,0,0,0.5);
        box-shadow: 1px 1px 1px rgba(0,0,0,0.5);				
    }
    /* Active state when the button is clicked */
    .button:active {
        /* Gives the effect of a down state */
        position: relative;
        top: 1px; 
        /* End */
        border-color: #888 #aaa #aaa #888;	
        background: #ccc;
        background: -moz-linear-gradient(100% 100% 90deg, #ccc, #aaa);
        background: -webkit-gradient(linear, left top, left bottom, from(#aaa), to(#ccc));		
        -webkit-box-shadow: 0 0 1px rgba(0,0,0,0.15);
        -moz-box-shadow: 0 0 1px rgba(0,0,0,0.15);
        box-shadow: 0 0 1px rgba(0,0,0,0.15);		
    }



    .buttonGreen {
    border: 4px solid #FFFFFF;
        border-radius: 10px;
        background-color: #00CC66;
        color: #ffffff;
        font-weight: bold;
        text-decoration: none;
        margin : 1px;
        padding: 5px 10px 5px 10px;
        display: inline-block;
    }
    .buttonGreen:hover {
    border: 2px solid #000000;
        background-color: #00CC66;
        color: #000000;
    }
    table
    {
        border-spacing:1px;
        border-style:solid;
        border-color:#2C4F85;
        font-family:Verdana, Arial, Helvetica, sans-serif;
        font-size:12px;
        padding:0;
        box-shadow:0px 0px #000000;
        table-layout:auto;
    }


    th
    {
        color:#333333 !important;
        background:#EFE0D1 !important;
        border-style:solid !important;
        border-width:0px !important;
        border-color:#2C4F85 !important;
        font-weight:bold !important;
        font-size:12px !important;
        padding:5px !important;
        text-align:left !important;
        vertical-align:top !important;
    }
    
    tr
    {
        color:#333333;
        font-weight:bold;
    }
    
    tr:hover td
    {
        color:#081C6B;
    }
    
    td
    {
        padding:3px 5px;
        text-align:left;
        vertical-align:top;
        font-weight:bold;
    }
    
    th:first-child
    {
        border-top-left-radius:10px;
    }
    
    th:last-child
    {
        border-top-right-radius:10px;
    }
    
    tr:last-child td:first-child
    {
        border-bottom-left-radius:10px;
    }
    
    tr:last-child td:last-child
    {
        border-bottom-right-radius:10px;
    }

    /* The CSS */
    select {
        padding:3px;
        margin: 0;
        -webkit-border-radius:4px;
        -moz-border-radius:4px;
        border-radius:4px;
        -webkit-box-shadow: 0 3px 0 #ccc, 0 -1px #fff inset;
        -moz-box-shadow: 0 3px 0 #ccc, 0 -1px #fff inset;
        box-shadow: 0 3px 0 #ccc, 0 -1px #fff inset;
        background: #f8f8f8;
        color:#000000;
        border:none;
        outline:none;
        display: inline-block;
        -webkit-appearance:none;
        -moz-appearance:none;
        appearance:none;
        cursor:pointer;
        font-size:14px;
        font-weight:bold;
    }

    /* Targetting Webkit browsers only. FF will show the dropdown arrow with so much padding. */
    @media screen and (-webkit-min-device-pixel-ratio:0) {
        select {padding-right:30px}
    }

    label {position:relative}
    label:after {
        content:'<>';
        font:11px "Consolas", monospace;
        color:#aaa;
        -webkit-transform:rotate(90deg);
        -moz-transform:rotate(90deg);
        -ms-transform:rotate(90deg);
        transform:rotate(90deg);
        right:8px; top:2px;
        padding:0 0 2px;
        border-bottom:1px solid #ddd;
        position:relative;
        pointer-events:none;
    }
    label:before {
        content:'';
        right:6px; top:0px;
        width:20px; height:20px;
        background:#f8f8f8;
        position:relative;
        pointer-events:none;
        display:block;
    }

    a.greenButtonRound {
        border: 4px solid #FFFFFF;
        border-radius: 10px;
        background-color: #C4830B;
        color: #ffffff;
        font-weight: bold;
        text-decoration: none;
        margin : 1px;
        padding: 5px 10px 5px 10px;
        display: inline-block;
    }
    a.greenButtonRound:hover {
        border: 2px solid #000000;
        background-color: #D1C494;
        color: #000000;
    }

    a.blueRound {
        border: 4px solid #FFFFFF;
        border-radius: 10px;
        background-color:#0000CC;
        color: #ffffff;
        font-weight: bold;
        text-decoration: none;
        margin : 1px;
        padding: 5px 10px 5px 10px;
        display: inline-block;
    }
    a.blueRound:hover {
        border: 2px solid #000000;
        background-color: #D1C494;
        color: #000000;
    }


    a.marunRound {
        border: 4px solid #FFFFFF;
        border-radius: 10px;
        background-color:#990000;
        color: #ffffff;
        font-weight: bold;
        text-decoration: none;
        margin : 1px;
        padding: 5px 10px 5px 10px;
        display: inline-block;
    }
    a.marunRound:hover {
        border: 2px solid #000000;
        background-color: #D1C494;
        color: #000000;
    }


    input[type=text] {
    border-radius:5px;
    -webkit-transition: all 0.30s ease-in-out;
    -moz-transition: all 0.30s ease-in-out;
    -ms-transition: all 0.30s ease-in-out;
    -o-transition: all 0.30s ease-in-out;
    outline: none;
    padding: 3px 0px 3px 3px;
    border: 1px
    solid #999;
    font-size:14px;
    font-weight:bold;
    }
    input[type=text]:focus{
    background-color:#FFF;
    border: 1px
    solid #07c;
    box-shadow: 0
    0 10px #07c;
    } 

    input[type=password] {
    border-radius:5px;
    -webkit-transition: all 0.30s ease-in-out;
    -moz-transition: all 0.30s ease-in-out;
    -ms-transition: all 0.30s ease-in-out;
    -o-transition: all 0.30s ease-in-out;
    outline: none;
    padding: 3px 0px 3px 3px;
    border: 1px
    solid #999;
    font-size:14px;
    font-weight:bold;
    }
    input[type=password]:focus{
    background-color:#FFF;
    border: 1px
    solid #07c;
    box-shadow: 0
    0 10px #07c;
    } 

    .mob{
    background-image:url(../images/mob_img.jpg);
    background-size: cover;
    background-repeat:no-repeat;
    font-family:Verdana, Arial, Helvetica, sans-serif;
    max-width:100%;
    font-size:12px;
    font-weight:bold;
    padding-left:3px;
    letter-spacing:4px;
    }

    .aadharimg{
    background-image:url(../images/aadhar_img.jpg);
    background-size: cover;
    background-repeat:no-repeat;
    font-family:Verdana, Arial, Helvetica, sans-serif;
    max-width:100%;
    font-size:12px;
    font-weight:bold;
    padding-left:3px;
    letter-spacing:4px;
    }

    #msg {display:none; position:absolute; z-index:200; background:url(../images/msg_arrow.gif) left center no-repeat; padding-left:7px}
    #msgcontent {display:block; font:Arial, Helvetica, sans-serif; font-weight:bold;color: #990000;font-size: 16px;background:#f3e6e6; border:2px solid #924949; border-left:none; padding:5px; min-width:150px; max-width:250px}

    .redLebel
    {
    color:#FF0000;
    font-size:24px;
    font-weight:bold;

    }

    .GreenLebel
    {
    color:#009900;
    font-size:16px;
    font-weight:bold;

    }

    .OrangeLebel
    {
    color:#CC6600;
    font-size:16px;
    font-weight:bold;

    }
    .MarunLebel
    {
    color:#800000;
    font-size:16px;
    font-weight:bold;

    }
    input[type="radio"]+label {
    width:25px;
    height:25px;
        color:#f2f2f2;
        font-family:Arial, sans-serif;
        font-size:14px;
    }

    input:-moz-read-only { /* For Firefox */
        background-color:#FFCC00;
    }

    input:read-only { 
        background-color:#FFFF66;
    }

    input[type="text"][readonly],
    textarea[readonly] {
    background-color: #FFFF66;
    }
    .info, .success, .warning, .error, .validation {
    border: 1px solid;
    margin: 10px 0px;
    padding:15px 10px 15px 150px;
    background-repeat: no-repeat;
    background-position: 10px center;
    }
    .info {
    color: #00529B;
    background-color: #BDE5F8;
    background-image: url('info.png');
    }
    .success {
    color: #4F8A10;
    background-color: #DFF2BF;
    background-image:url('../images/success.png');
    }
    .warning {
    color: #9F6000;
    background-color: #FEEFB3;
    background-image: url('warning.png');
    }
    .error {
    color: #D8000C;
    background-color: #FFBABA;
    background-image: url('../images/error.png');
    }

    .control-group {
        display: inline-block;
        width: 200px;
        height: 210px;
        margin: 10px;
        padding: 30px;
        text-align: left;
        vertical-align: top;
        background: #fff;
        box-shadow: 0 1px 2px rgba(0,0,0,.1);
    }

    .control {
        font-size: 18px;
        position: relative;
        display: block;
        margin-bottom: 15px;
        padding-left: 30px;
        cursor: pointer;
    }

    .control input {
        position: absolute;
        z-index: -1;
        opacity: 0;
    }

    .control__indicator {
        position: absolute;
        top: 2px;
        left: 0;
        width: 20px;
        height: 20px;
        background: #e6e6e6;
    }

    .control--radio .control__indicator {
        border-radius: 50%;
    }

    .mtextarea{
    font-size:0.9em;
    color:#6da021;
    border:1px solid #6da021;
    padding-left:10px;
    font-family: tahoma, sans-serif;
    font-size:20px;
    font-weight:bold;
    }

    .buttonGreen {
    border: 4px solid #006600;
        border-radius: 10px;
        background-color: #006600;
        color: #006600;
        font-weight: bold;
        text-decoration: none;
        margin : 1px;
        padding: 5px 10px 5px 10px;
        display: inline-block;
    }
    .buttonGreen:hover {
    border: 2px solid #006600;
        background-color: #006600;
        color: #000000;
    }
    
    .buttonOrange {
    border: 4px solid #A84300;
        border-radius: 10px;
        background-color: #FF6600;
        color: #ffffff;
        font-weight: bold;
        text-decoration: none;
        margin : 1px;
        padding: 5px 10px 5px 10px;
        display: inline-block;
    }
    .buttonOrange:hover {
    border: 2px solid #A84300;
        background-color: #FF6600;
        color: #000000;
    }

    /*.buttonMerun {
    border: 4px solid #A84300;
        border-radius: 10px;
        background-color: #990000;
        color: #ffffff;
        font-weight: bold;
        text-decoration: none;
        margin : 1px;
        padding: 5px 10px 5px 10px;
        display: inline-block;
    }*/
    .buttonMerun {
    border: 4px solid #A84300;
        border-radius: 10px;
        background-color: #990000;
        color: #ffffff;
        font-weight: bold;
        text-decoration: none;
        margin : 1px;
        padding: 5px 10px 5px 10px;
        display: inline-block;
    }

    .buttonMerun:hover {
    border: 2px solid #A84300;
        background-color: #990000;
        color: #000000;
    }
    
    .buttonBlue {
    border: 4px solid #A84300;
        border-radius: 10px;
        background-color:  #000099;
        color: #ffffff;
        font-weight: bold;
        text-decoration: none;
        margin : 1px;
        padding: 5px 10px 5px 10px;
        display: inline-block;
    }
    .buttonBlue:hover {
    border: 2px solid #A84300;
        background-color:  #000099;
        color: #000000;
    }
    
    .buttonGray {
    border: 4px solid #A84300;
        border-radius: 10px;
        background-color:  #996633;
        color: #ffffff;
        font-weight: bold;
        text-decoration: none;
        margin : 1px;
        padding: 5px 10px 5px 10px;
        display: inline-block;
    }
    .buttonGray:hover {
    border: 2px solid #A84300;
        background-color:  #996633;
        color: #000000;
    }
    
    .custom-select {
    position: relative;
    width: 90%;
    height: 36px;
    border: 1px solid ;

    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -o-user-select: none;
    user-select: none;
    background-color: #D9DBE1;
    font-weight: bold;
    font-size: 11px; 
    font-family: Verdana,  Arial, Sans-Serif; 
    font-style: normal;
    }
    .custom-select a {
    display: inline-block;
    width: 90%;
    height: 20px;
    padding: 8px 10px;
    color: #000;
    background-color: #D9DBE1;
    text-decoration: none;
    cursor: pointer;
    }
    }
    .custom-select a span {
    display: inline-block;
    width: 90%;
    white-space: nowrap;
    overflow: hidden;
    }
    .custom-select select {
    display: none !important;
    }
    .custom-select > div {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    margin: 1px 0 0 -1px;
    width: 100%;
    border: 1px solid #888;
    border-top: 0;
    background: #FFFFFF;
    z-index: 10;
    overflow: hidden;
    }
    .custom-select input {
    width: 90%;
    border: 1px solid #888;
    margin: 5px 5px 0;
    padding: 5px;
        font-weight: bold;
    font-size: 11px; 
    font-family: Verdana,  Arial, Sans-Serif; 
    font-style: normal;
    background: #fff url('../images/multilist.search.png') no-repeat 5px 50%;
    line-height: 2em;
    padding: 2px 5px 2px 25px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    background-color: #EAEBEE;
    
    }

    .custom-select loading{
        background: white url('../images/multilist.indicator.gif') right center no-repeat;
        
    }

    .custom-select > div > div {
    position: relative;
    overflow-x: hidden;
    overflow-y: visible;
    margin: 5px;
    max-height: 250px;
    }
    .custom-select div ul {
    padding: 0;
    margin: 0;
    list-style: none;
    }
    .custom-select div ul li {
    display: none;
    padding: 5px;
    }
    .custom-select div ul li.active {
    display: block;
    cursor: pointer;
    }
    .custom-select div ul li:hover {
    background: #9298A9;
    color: #fff;
    }
    .custom-select div ul li.option-hover {
    background: #808040;
    color: #fff;
    }
    .custom-select div ul li.option-disabled {
    color: #999;
    }
    .custom-select div ul li.option-disabled:hover {
    background: #ff9999;
    color: #C4C8D2;
    }
    .custom-select div ul li.option-hover.option-disabled {
    background: #ff6666;
    color: #C4C8D2;
    }
    .custom-select div ul li.no-results {
    display: none;
    background: #f2f2f2;
    color: #000;
    }

    .autocomplete-suggestions strong {
        font-weight: normal; 
        color: #3399ff;
        }

    /* Custom Select - Open
    ----------------------------------*/
    .custom-select-open {
    border-bottom: 1px solid ;
        background-color: #D9DBE1;
    }
    .custom-select-open div {
    display: block;
        background-color: #D9DBE1;
    }

    /* Hide Input Box
    ----------------------------------*/
    .custom-select input.custom-select-hidden-input {
    position: absolute !important;
    top: 0 !important;
    left: -1000px !important;
    padding: 0 !important;
    margin: 0 !important;
    border: 0 !important;
    background: transparent !important;
    z-index: -1 !important;
    }

    /* Mobile Override
    ----------------------------------*/
    .custom-select-mobile select {
    display: inline !important;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    }
</style>
<style>
    .application-form{
        width: 100%;
        overflow: hidden;
    }
</style>
@section('scripts')
    <script>
        window.APPLICATION = {
            TAB: '{{ $formDesign->slug }}'
        };
        @if ($application)
            window.APPLICATION.DATA = {!! json_encode($application->data) !!};
        @else
            window.APPLICATION.DATA = {};
        @endif
    </script>
@endsection
