<div>
    <p style="margin: 0">Name: {{ $data->transporter->name }}</p>
    <p style="margin: 0">Date: {{ $data->date }}</p>
    <p style="margin: 0">Goods: {{ ucfirst(implode(", ", array_column($data->goods, 'name'))) }}</p>
    <p style="margin: 0">Amount: {{ $data->amount }} Tk</p>
</div>
