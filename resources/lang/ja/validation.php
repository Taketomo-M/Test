<?php

return [
    'required' => ':attribute を入力してください。',
    'email' => ':attribute は正しいメールアドレス形式で入力してください。',
    'min' => [
    'string' => ':attribute は :min 文字以上で入力してください。',
    'numeric' => ':attribute は :min 以上で入力してください。',
],
    'confirmed' => ':attribute が確認欄と一致しません。',
    'unique' => 'その :attribute は既に使われています。',
    'attributes' => [
    'email' => 'メールアドレス',
    'password' => 'パスワード',
    'password_confirmation' => 'パスワード（確認）',
    'quantity' => '購入数',
],
];
