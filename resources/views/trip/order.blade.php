<div>
    <p style="margin: 0">Name: {{ $data->transporter->name }}</p>
    <p style="margin: 0">Date: {{ $data->date }}</p>
    <p style="margin: 0">Goods: {{ ucfirst($data->goods->pluck('name')->implode(',')) }}</p>
</div>
