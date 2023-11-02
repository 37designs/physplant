<!DOCTYPE html>

<html>
<head>
    <title>Parts System</title>
</head>

<body>

<h1>New Parts Request</h1>

<h4>Summary</h4>
<table style="border: 1px solid black;border-collapse: collapse;">
    <tr>
        <th style="padding: 0.25em;border: 1px solid black;">Quantity</th>
        <th style="padding: 0.25em;border: 1px solid black;">Part #</th>
        <th style="padding: 0.25em;border: 1px solid black;">Vendor</th>
        <th style="padding: 0.25em;border: 1px solid black;">Description</th>
        <th style="padding: 0.25em;border: 1px solid black;">Expedite</th>
        <th style="padding: 0.25em;border: 1px solid black;">Status</th>
        <th style="padding: 0.25em;border: 1px solid black;">ETA</th>
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
            <td style="padding: 0.25em;border: 1px solid black;">{{ $part->receivedStatus->name }}</td>
            <td style="padding: 0.25em;border: 1px solid black;">
                @if(isset($part->eta))
                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $part->eta)->format('Y-m-d') }}
                @else
                    None
                @endif
            </td>
        </tr>
    @endforeach
</table>


</body>
</html>