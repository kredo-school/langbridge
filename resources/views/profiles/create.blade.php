<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>プロフィール作成</title>
</head>

<body>
    <h1>プロフィール作成（テスト用）</h1>

    <form action="{{ route('profiles.store') }}" method="POST">
        @csrf

        <label>Handle Name:</label>
        <input type="text" name="handle" required><br><br>

        <label>興味カテゴリ:</label><br>
        @foreach($interests as $interest)
        <label>
            <input type="checkbox" name="interests[]" value="{{ $interest->id }}">
            {{ $interest->name }}
        </label><br>
        @endforeach

        <br>
        <button type="submit">登録</button>
    </form>
</body>

</html>