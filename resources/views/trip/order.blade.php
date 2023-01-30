<table style="width: 480px; margin: 0 auto; border="0">
    <tr>
        <td colspan="2">
            <h1 style="text-align: center">Your Trip</h1>
        </td>
    </tr>
    <tr>
        <td>Name</td>
        <td style="text-align:right">{{ $data->transporter->name }}</td>
    </tr>
    <tr>
        <td>Date</td>
        <td style="text-align:right">{{ $data->date }}</td>
    </tr>
    <tr>
        <td>Goods</td>
        <td style="text-align:right">{{ ucfirst(implode(",", array_column($data->goods, 'name'))) }}</td>
    </tr>
    <tr>
        <td>Amount</td>
        <td style="text-align:right">{{ $data->amount }} Tk</td>
    </tr>
</table>
