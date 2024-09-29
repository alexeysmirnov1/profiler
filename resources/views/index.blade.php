<html>
<head>
    <meta charset="UTF-8">
    <title>Profiler</title>
</head>
<body>
<div>
    <h1>web usage</h1>
    @foreach($usage['web'] as $user)
        <div>{{ $user['user'] }} {{ $user['times'] }}</div>
    @endforeach
</div>
<div>
    <h1>api usage</h1>
    @foreach($usage['api'] as $user)
        <div>{{ $user['user'] }} {{ $user['times'] }}</div>
    @endforeach
</div>
<div>
    <h1>admin usage</h1>
    @foreach($usage['admin'] as $user)
        <div>{{ $user['user'] }} {{ $user['times'] }}</div>
    @endforeach
</div>
<div>
    <h1>requests</h1>
    <table>
    @foreach($requests as $request)
        <tr>
            @foreach($request as $value)
                <td>{{ $value }}</td>
            @endforeach
        </tr>
    @endforeach
    </table>
</div>
<div>
    <h1>queries</h1>
    <table>
        @foreach($queries as $request)
            <tr>
                @foreach($request as $value)
                    <td>{{ $value }}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
</div>
<div>
    <h1>cache</h1>
</div>
<div>
    <h1>queues</h1>
</div>
<div>
    <h1>cron</h1>
</div>
<div>
    <h1>routers</h1>
</div>
<div>
    <h1>Mails</h1>
</div>
</body>
</html>
