@extends('layouts.app')

@section('header')
Expenses
@endsection

@section('content')
<center>
    <div class="form-section">
        <form action="{{ route('new.expense') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <select name="project">
                @foreach ($project as $proj)
                <option value="{{$proj->project}}">{{$proj->project}}</option>
                @endforeach
            </select>
            <input type="text" name="item" placeholder="Item Name">
            <input type="number" name="price" placeholder="Price">
            <button type="submit">Insert</button>
        </form>
    </div>

    <div class="form-section">
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
    </div>
    
</center>
@endsection