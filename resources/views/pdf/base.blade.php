<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
        <title>@yield('title')</title>
        <style type="text/css">
            *{font-family: DejaVu Sans, sans-serif !important;font-size: 14px;}
            h3{font-size: large;}
            small{font-size: small;}
            .text-left{text-align: left;}
            .text-right{text-align: right;}
            .text-center{text-align: center;}
            table.bordered, table.bordered>tbody>tr>th, table.bordered>tbody>tr>td, table.bordered>thead>tr>th, table.bordered>thead>tr>td, table.bordered>tfoot>tr>th, table.bordered>tfoot>tr>td{border: 1px solid #333;border-collapse: collapse;}
            th, td{padding: 5px 3px;text-align: left;}
            .w50{width: 50%;}
            .w100{width: 100%;}
            .spacer{height: 1rem;display: block;}
        </style>
        @yield('style')
    </head>
    <body class="w100">
        @yield('content')
    </body>
</html>