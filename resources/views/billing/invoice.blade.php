<div style="text-align: center">
    <h1>Your Billing Invoice</h1>
    @if(!empty($data))
        <table style="width: 100%; text-align: left" border="1">
            <tr>
                <th>Date</th>
                <th style="text-align: right">Amount</th>
            </tr>
            @foreach($data as $value)
            <tr>
                <td>{{ $value->date }}</td>
                <td style="text-align: right">{{ $value->amount }} Tk</td>
            </tr>
            @endforeach
        </table>
    @endif
</div>
