<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Order Print</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            table{
                width:100%;
                border:none;
                border-collapse:collapse;

                font-size:14px;
            }
            tr{
                height:64px;
            }
            th,td{
                padding:12px;
                text-align:left;
                vertical-align:top;
            }
            .wrapper{
                display:block
            }
            .text-right{
                text-align:right;
            }
            .data-row th{
                border:1px solid #666;
            }
            .data-row td{
                border-left:1px solid #666;
                border-right:1px solid #666;
            }
            .p-0{
                padding:0px;
            }
            .task{
                width:50%; 
                float: left;
            }
        </style>

    </head>
    <body>
        <div class="header" style="text-align: center;">
            <img src="{{asset('uploads/company_logo/' . $userDetails->city)}}" style="height:90px;" alt="Logo" title="Logo" />
            <h3 style="text-align: center;">{{ $userDetails->first_name }}</h3>
            <h5 style="text-align: center;">Address : {{ $userDetails->address }}</h5>
        </div>
        <div class="main">
            <table border="1">
                <tbody>
                    <tr>
                        <th width="25%">Name</th>
                        <td width="25%">{{ $order_data->name }}</td>
                        <th width="25%">Mobile</th>
                        <td width="25%">{{ $order_data->mobile_no }}</td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td>{{ date('d-m-Y', strtotime($order_data->order_date)) }}</td>
                        <th>Time</th>
                        <td>{{ date('h:i A', strtotime($order_data->order_time)) }}</td>
                    </tr>
                    <tr>
                        <th>Car</th>
                        <td>{{ $order_data->car_name }}</td>
                        <th>Model</th>
                        <td>{{ $order_data->model_name }}</td>
                    </tr>
                    <tr>
                        <th>Model Year</th>
                        <td>{{ $order_data->model_year }}</td>
                        <th>Mileage</th>
                        <td>{{ $order_data->mileage }}</td>
                    </tr>
                    <tr>
                        <th>Receiver Name</th>
                        <td>{{ $order_data->first_name }}</td>
                        <th>Expected Date of Delivery</th>
                        <td>{{ date('d-m-Y', strtotime($order_data->expected_delivery_date)) }}</td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td>{{ $order_data->price }}</td>
                        <th></th>
                        <td></td>
                    </tr>
<!--                    <tr>
                        <th colspan="4"></th>
                    </tr>-->
                    <tr>
                        <th colspan="4">
                            Tasks :
                            <table>
                                <tr>
                                    @forelse($tasks as $task_key => $task_value)
                                        <td>
                                            <?php
                                                $checkbox_value = '';
                                                if(isset($checked_tasks) && in_array($task_value->id, $checked_tasks)) {
                                                    $checkbox_value = '[checked]';
                                                }
                                            ?>
                                            {{ Form::checkbox('checked_tasks[]', $task_value->id, $checkbox_value, ['id' => 'task_id_' . $task_value->id]) }}
                                            {{ Form::label('task_id_' . $task_value->id, $task_value->task_name, ['class' => 'control-label']) }}
                                        </td>
                                        @if($task_key%2 == 1)
                                            </tr><tr>
                                        @endif
                                    @empty
                                    @endforelse
                                </tr>
                            </table>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="footer">
        </div>
    </body>
</html>