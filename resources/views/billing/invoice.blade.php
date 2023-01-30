<table style="width: 480px; margin: 0 auto; text-align: left;" border="0">
    <tr>
        <td colspan="2">
            <h1 style="text-align: center">Your Billing Invoice</h1>
        </td>
    </tr>
    <tr>
        <th>Date</th>
        <th style="text-align: right">Amount</th>
    </tr>
    @if(!empty($data) & (count($data) > 0))
        @foreach($data as $value)
            <tr>
                <td>{{ $value->date }}</td>
                <td style="text-align: right">{{ $value->amount }} Tk</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="2" style="text-align: center">Your billing invoice is empty</td>
        </tr>
    @endif
</table>
