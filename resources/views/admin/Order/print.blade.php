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
            .page-break {
                page-break-after: always;
            }
        </style>

    </head>
    <body>
        <div class="header">
            <table>
                <tr>
                    <td width="60%" style="text-align: left; padding: 0px;">
                        <strong>{{ $userDetails->first_name }}</strong><br>
                        Address : {!! nl2br(e($userDetails->address)) !!}
                    </td>
                    <td width="40%" style="text-align: right; padding: 0px;">
                        <img src="{{asset('uploads/company_logo/' . $userDetails->city)}}" style="height:90px;" alt="Logo" title="Logo" />
                    </td>
                </tr>
            </table>
        </div>
        <div class="main">
            <table border="1">
                <tbody>
                    <tr>
                        <th width="25%">Name</th>
                        <td width="25%">{{ $order_data->name }}</td>
                        <th width="25%">Order No.</th>
                        <td width="25%">{{ $order_data->id }}</td>
                    </tr>
                    <tr>
                        <th>Mobile</th>
                        <td>{{ $order_data->mobile_no }}</td>
                        <th>Date</th>
                        <td>{{ date('d-m-Y', strtotime($order_data->order_date)) }}</td>
                    </tr>
                    <tr>
                        <th>Car</th>
                        <td>{{ $order_data->car_name }}</td>
                        <th>Time</th>
                        <td>{{ date('h:i A', strtotime($order_data->order_time)) }}</td>
                    </tr>
                    <tr>
                        <th>Model</th>
                        <td>{{ $order_data->model_name }}</td>
                        <th>Model Year</th>
                        <td>{{ $order_data->model_year }}</td>
                    </tr>
                    <tr>
                        <th>Mileage</th>
                        <td>{{ $order_data->mileage }}</td>
                        <th>Exp. Date of Delivery</th>
                        <td>{{ date('d-m-Y', strtotime($order_data->expected_delivery_date)) }}</td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td>{{ $order_data->price }}</td>
                        <th>Receiver Name</th>
                        <td>{{ $order_data->first_name }}</td>
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
                                        <td style="padding: 8px;">
                                            <?php
                                                $checkbox_value = '';
                                                if(isset($checked_tasks) && in_array($task_value->id, $checked_tasks)) {
                                                    $checkbox_value = '[checked]';
                                                }
                                            ?>
                                            {{ Form::checkbox('checked_tasks[]', $task_value->id, $checkbox_value, ['id' => 'task_id_' . $task_value->id, 'style' => 'font-size:22px;']) }}
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
            <div class="page-break"></div>
            <table>
                <tr>
                    <td style="text-align: center;">
                        <img src="{{asset('images/car-tap-useme.png')}}" style="height:350px;" alt="Car Parts Image" title="Car Parts Image" />
                    </td>
                </tr>
                @forelse($car_part_details as $car_part_key => $car_part_value)
                    <tr>
                        <td>
                            <strong>{{ $car_part_key + 1 }}. {{ $car_parts[$car_part_value->car_part_name] }} : </strong>
                            {!! nl2br(e($car_part_value->car_part_detail)) !!}
                        </td>
                    </tr>
                @empty
                @endforelse
            </table>
            <div class="page-break"></div>
            <table>
                @forelse($car_part_details as $car_part_key => $car_part_value)
                    <tr>
                        <td>
                            <strong>{{ $car_part_key + 1 }}. {{ $car_parts[$car_part_value->car_part_name] }} : </strong>
                            @if(!empty($car_part_value->car_part_image))
                                <div style="width: 100%; text-align: center;"><br>
                                    <img src="{{ asset('uploads/car_part_image/'. $car_part_value->car_part_image) }}" atr="car_part_image_tag" title="car_part_image_tag" style="height:270px;">
                                </div>
                            @else
                                <small>No Image</small>
                            @endif
                        </td>
                    </tr>
                @empty
                @endforelse
            </table>
        </div>
        <div class="footer">
        </div>
    </body>
</html>