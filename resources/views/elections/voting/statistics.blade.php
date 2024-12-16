@extends('layouts.elections')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <h2 class="mb-4">Election Statistics for {{ $latestElection->name }}</h2>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Group</th>
                    <th>Category</th>
                   <!--  <th>Total Practitioners</th> -->
                    <th>Pactitioner Registered To Vote</th>
                    <th>Practitioners Who Voted</th>
                    <th>Percentage Voted</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statistics as $index => $stat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $stat['group'] }}</td>
                    <td>{{ $stat['category'] }}</td>
                   <!--  <td>{{ $stat['total_practitioners'] }}</td> -->
                    <td>{{ $stat['updated_practitioners'] }}</td>
                    <td>
                        @if($stat['voted_practitioners'] == 0)
                            0 (Duly Elected)
                        @else
                            {{ $stat['voted_practitioners'] }}
                        @endif
                    </td>
                    <td>
                        @if($stat['updated_practitioners'] > 0)
                            {{ number_format(($stat['voted_practitioners'] / $stat['updated_practitioners']) * 100, 2) }}%
                        @else
                            0%
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection