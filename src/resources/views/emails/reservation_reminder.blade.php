<!DOCTYPE html>
<html>

<head>
    <title>Reservation Reminder</title>
</head>

<body>
    <h1>{{ $customerName }}様</h1>
    <p>本日のご予約のご連絡です。</p>
    <p> Shop: {{ $reservationShop }} </p>
    <p> Date: {{ $reservationDate }} </p>
    <p> Time: {{ $reservationTime }} </p>
    <p>ご来店をお待ちしております。</p>
</body>

</html>
