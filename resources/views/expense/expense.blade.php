@extends('layouts.app')

@section('header')
Expenses
@endsection

@section('content')
<div class="form-section">
    <center>
        <table>
            <th>Project Name</th>
            <th>Consumed</th>
            <th>Amount</th>
            @foreach ($expense as $index => $expen)
                <tr>
                    <td>{{$expen}}</td>
                </tr>
            @endforeach
        </table>
    </center>
</div>
@endsection