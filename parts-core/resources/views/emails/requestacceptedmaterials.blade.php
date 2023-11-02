<!DOCTYPE html>

<html>
<head>
    <title>Parts System</title>
</head>

<body>

<h1>New Parts Request</h1>

<p>There is a new parts request for you! You can check it out
    <a href="{{ URL::route('requests') . "/materials/" . $requestID }}">HERE</a>
    or go to the parts page.</p>

</body>
</html>