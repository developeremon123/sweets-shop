<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Purchase Confirm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        #invoice{
        padding: 30px;
    }
    .invoice {
        position: relative;
        background-color: #FFF;
        min-height: 680px;
        padding: 15px
    }
    .invoice header {
        padding: 10px 0;
        margin-bottom: 20px;
        border-bottom: 1px solid #3989c6
    }
    .invoice .company-details {
        text-align: right
    }
    .invoice .company-details .name {
        margin-top: 0;
        margin-bottom: 0
    }
    .invoice .contacts {
        margin-bottom: 20px
    }
    .invoice .invoice-to {
        text-align: left
    }
    .invoice .invoice-to .to {
        margin-top: 0;
        margin-bottom: 0
    }
    .invoice .invoice-details {
        text-align: right
    }
    .invoice .invoice-details .invoice-id {
        margin-top: 0;
        color: #3989c6
    }
    .invoice main {
        padding-bottom: 50px
    }
    .invoice main .thanks {
        margin-top: -100px;
        font-size: 2em;
        margin-bottom: 50px
    }
    .invoice main .notices {
        padding-left: 6px;
        border-left: 6px solid #3989c6
    }
    .invoice main .notices .notice {
        font-size: 1.2em
    }
    .invoice table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 20px
    }
    .invoice table td,.invoice table th {
        padding: 15px;
        background: #eee;
        border-bottom: 1px solid #fff
    }
    .invoice table th {
        white-space: nowrap;
        font-weight: 400;
        font-size: 16px
    }
    .invoice table td h3 {
        margin: 0;
        font-weight: 400;
        color: #3989c6;
        font-size: 1.2em
    }
    .invoice table .qty,.invoice table .total,.invoice table .unit {
        text-align: right;
        font-size: 1.2em
    }
    .invoice table .no {
        color: #fff;
        font-size: 1.6em;
        background: #3989c6
    }
    .invoice table .unit {
        background: #ddd
    }
    .invoice table .total {
        background: #3989c6;
        color: #fff
    }
    .invoice table tbody tr:last-child td {
        border: none
    }
    .invoice table tfoot td {
        background: 0 0;
        border-bottom: none;
        white-space: nowrap;
        text-align: right;
        padding: 10px 20px;
        font-size: 1.2em;
        border-top: 1px solid #aaa
    }
    .invoice table tfoot tr:first-child td {
        border-top: none
    }
    .invoice table tfoot tr:last-child td {
        color: #3989c6;
        font-size: 1.4em;
        border-top: 1px solid #3989c6
    }
    .invoice table tfoot tr td:first-child {
        border: none
    }
    .invoice footer {
        width: 100%;
        text-align: center;
        color: #777;
        border-top: 1px solid #aaa;
        padding: 8px 0
    }
    @media print {
        .invoice {
            font-size: 11px!important;
            overflow: hidden!important
        }
        .invoice footer {
            position: absolute;
            bottom: 10px;
            page-break-after: always
        }
        .invoice>div:last-child {
            page-break-before: always
        }
    }
    </style>
    <!------ Include the above in your HEAD tag ---------->
  </head>
  <body>
    <div class="invoice">
        <div class="toolbar hidden-print">
            <div class="text-end">
                <button id="printVoice" class="btn btn-info"><i class="fa-solid fa-print"></i></button>
                <button class="btn btn-info"><i class="fa-solid fa-file-pdf"></i></button>
            </div>
            <hr>
        </div>
        <div class="invoice overflow-auto">
            <div style="min-width:600px">
                <header>
                    <div class="row">
                        <div class="col">
                            <a href="#" target="_blank">
                                <img src="{{ asset('assets/frontend/images/logo.png') }}" data-holder-rendered="true" alt="">
                            </a>
                        </div>
                        <div class="col company-details">
                            <h2 class="name">
                                <a href="{{ route('home') }}" target="_blank">{{ env('APP_NAME') }}</a>
                            </h2>
                            <div>Ecommerce store address</div>
                            <div>Ecommerce store mobile number</div>
                            <div>company@example.com</div>
                        </div>
                    </div>
                </header>
                <main>
                    @foreach ($Ordel_details as $order)
                        <div class="row contacts">
                            <div class="col invoice-to">
                                <div class="text-gray-light">INVOICE TO:</div>
                                <h2 class="to">{{ $order->billing->name }}</h2>
                                <div class="address"><i class="fa-solid fa-house"></i>{{$order->billing->address }}</div>
                                <div class="phoneNumber"><i class="fa-solid fa-mobile"></i></i>{{$order->billing->phone }}</div>
                                <div class="email"><i class="fa-solid fa-envelope"></i>{{$order->billing->email }}</div>
                            </div>
                            <div class="col invoice-details">
                                <h1 class="invoice-id">INVOICE 3-2-1</h1>
                                <div class="date">Date of Invoice: {{ $order->created_at->format('d/m/y') }}</div>
                                <div class="date">Due Date: {{ $order->created_at->format('d/m/y') }}</div>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-start">DESCRIPTION</th>
                                    <th class="text-end">QUANTITY</th>
                                    <th class="text-end">UNIT PRICE</th>
                                    <th class="text-end">SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderdetails as $item)
                                    <tr>
                                        <td class="no">{{ $loop->index+1 }}</td>
                                        <td class="text-start">
                                            <h3>
                                                {{ $item->product->name }}
                                            </h3>
                                        </td>
                                        <td class="unit">{{ $item->product_qty }}</td>
                                        <td class="qty">ট
                                             {{ $item->product_price }}
                                        </td>
                                        <td class="total">ট
                                            {{ $item->product_price*$item->product_qty }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan='2'></td>
                                    <td colspan='2'>Discount({{ $order->cuponName }})</td>
                                    <td>ট {{ $order->discount_amount }}</td>
                                </tr>
                                <tr>
                                    <td colspan='2'></td>
                                    <td colspan='2'>SUBTOTAL</td>
                                    <td>ট {{ $order->total }}</td>
                                </tr>
                                <tr>
                                    <td colspan='2'></td>
                                    <td colspan='2'>GRAND TOTAL</td>
                                    <td>ট {{ $order->total }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    @endforeach
                    <div class="thanks">Thank you!</div>
                </main>
                <footer>
                    Invoice was created on a computer and is valid without the signature and seal.
                </footer>
            </div>
            <div></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $('#printInvoice').click(function(){
               Popup($('.invoice')[0].outerHTML);
               function Popup(data)
               {
                   window.print();
                   return true;
               }
           });
   </script>
  </body>
</html>