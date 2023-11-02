<!DOCTYPE html>

<html>
<head>
    <title>Parts System</title>
</head>

<body>

<h1>Parts Request Update</h1>

<h4>Updated Summary</h4>
<table style="border: 1px solid black;border-collapse: collapse;">
    <tr>
        <th style="padding: 0.25em;border: 1px solid black;">Quantity</th>
        <th style="padding: 0.25em;border: 1px solid black;">Part #</th>
        <th style="padding: 0.25em;border: 1px solid black;">Vendor</th>
        <th style="padding: 0.25em;border: 1px solid black;">Description</th>
        <th style="padding: 0.25em;border: 1px solid black;">Expedite</th>
    </tr>
    @foreach($parts as $part)
        <tr>
            <td style="padding: 0.25em;border: 1px solid black;">{{ $part->final_quantity }}</td>
            <td style="padding: 0.25em;border: 1px solid black;">{{ $part->part_number }}</td>
            <td style="padding: 0.25em;border: 1px solid black;">{{ $part->vendor->name }}</td>
            <td style="padding: 0.25em;border: 1px solid black;">{{ $part->description }}</td>
            <td style="padding: 0.25em;border: 1px solid black;">
                @if($part->expedite)
                    Yes
                @else
                    No
                @endif
            </td>
        </tr>
    @endforeach
</table>

</body>
</html>