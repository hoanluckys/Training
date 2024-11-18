<?php

return [
    // Thông báo cho các quy tắc xác thực chung
    'Required' => '{attribute} không được để trống.',
    'Email' => 'Địa chỉ email không hợp lệ.',
    'String' => '{attribute} phải là một chuỗi.',
    'Min' => '{attribute} phải có ít nhất {min} ký tự.',
    'Max' => '{attribute} không được dài quá {max} ký tự.',

    // Thông báo cho các quy tắc xác thực riêng biệt
    'Safe' => '{attribute} không hợp lệ.',
    'Match' => '{attribute} không khớp.',
    'Compare' => '{attribute} không khớp với {compareValue}.',

    // Thông báo cho từng thuộc tính nếu cần thiết
    'username' => [
        'required' => 'Tên người dùng là bắt buộc.',
        'unique' => 'Tên người dùng đã tồn tại.',
    ],
    'email' => [
        'required' => 'Email là bắt buộc.',
        'email' => 'Email không đúng định dạng.',
    ],
];
