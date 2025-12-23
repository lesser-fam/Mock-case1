@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="css/register.css">
@endsection

@section('content')
    <div class="register-form">
        <p class="register-form__heading">プロフィール</p>
            <div class="register-form__inner">
                
            </div>

            <div>
                <a href="{{ route('mypage.profile.edit', ['from' => 'mypage']) }}">プロフィールを編集</a>
            </div>
    </div>
@endsection