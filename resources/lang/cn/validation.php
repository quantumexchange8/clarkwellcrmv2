<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute必須接受。',
    'accepted_if' => '當:other是:value時，:attribute必須接受。',
    'active_url' => ':attribute不是一個有效的URL。',
    'after' => ':attribute必須是:date之後的日期。',
    'after_or_equal' => ':attribute必須是:date之後或等於:date的日期。',
    'alpha' => ':attribute只能包含字母。',
    'alpha_dash' => ':attribute只能包含字母、數字、短橫線和下劃線。',
    'alpha_num' => ':attribute只能包含字母和數字。',
    'array' => ':attribute必須是一個數組。',
    'before' => ':attribute必須是:date之前的日期。',
    'before_or_equal' => ':attribute必須是:date之前或等於:date的日期。',
    'between' => [
        'numeric' => ':attribute必須介於:min和:max之間。',
        'file' => ':attribute必須介於:min和:max千字節之間。',
        'string' => ':attribute必須介於:min和:max個字符之間。',
        'array' => ':attribute必須有:min到:max個項。',
    ],
    'boolean' => ':attribute字段必須為真或假。',
    'confirmed' => ':attribute確認不匹配。',
    'current_password' => '密碼不正確。',
    'date' => ':attribute不是一個有效的日期。',
    'date_equals' => ':attribute必須是等於:date的日期。',
    'date_format' => ':attribute不匹配格式:format。',
    'declined' => ':attribute必須被拒絕。',
    'declined_if' => '當:other是:value時，:attribute必須被拒絕。',
    'different' => ':attribute和:other必須不同。',
    'digits' => ':attribute必須是:digits位數字。',
    'digits_between' => ':attribute必須介於:min和:max位數字之間。',
    'dimensions' => ':attribute具有無效的圖像尺寸。',
    'distinct' => ':attribute字段具有重複值。',
    'email' => ':attribute必須是一個有效的電子郵件地址。',
    'ends_with' => ':attribute必須以以下之一結尾: :values。',
    'enum' => '所選的:attribute無效。',
    'exists' => '所選的:attribute無效。',
    'file' => ':attribute必須是一個文件。',
    'filled' => ':attribute字段必須有一個值。',
    'gt' => [
        'numeric' => ':attribute必須大於:value。',
        'file' => ':attribute必須大於:value千字節。',
        'string' => ':attribute必須大於:value個字符。',
        'array' => ':attribute必須有:value項以上。',
    ],
    'max' => [
        'numeric' => ':attribute 不能大于 :max。',
        'file' => ':attribute 不能大于 :max 千字节。',
        'string' => ':attribute 不能大于 :max 个字符。',
        'array' => ':attribute 不能有超过 :max 个项目。',
    ],
    'mimes' => ':attribute 必须是类型为 :values 的文件。',
    'mimetypes' => ':attribute 必须是类型为 :values 的文件。',
    'min' => [
        'numeric' => ':attribute 必须至少为 :min。',
        'file' => ':attribute 必须至少为 :min 千字节。',
        'string' => ':attribute 必须至少为 :min 个字符。',
        'array' => ':attribute 必须至少有 :min 个项目。',
    ],
    'multiple_of' => ':attribute 必须是 :value 的倍数。',
    'not_in' => ':attribute 的选择无效。',
    'not_regex' => ':attribute 格式无效。',
    'numeric' => ':attribute 必须是一个数字。',
    'password' => '密码不正确。',
    'present' => ':attribute 字段必须存在。',
    'prohibited' => ':attribute 字段被禁止。',
    'prohibited_if' => '当 :other 为 :value 时，:attribute 字段被禁止。',
    'prohibited_unless' => '除非 :other 在 :values 中，否则 :attribute 字段被禁止。',
    'prohibits' => ':attribute 字段禁止存在 :other。',
    'regex' => ':attribute 格式无效。',
    'required' => ':attribute 字段是必填的。',
    'required_if' => '当 :other 为 :value 时，:attribute 字段是必填的。',
    'required_unless' => '除非 :other 在 :values 中，否则 :attribute 字段是必填的。',
    'required_with' => '当 :values 存在时，:attribute 字段是必填的。',
    'required_with_all' => '当 :values 都存在时，:attribute 字段是必填的。',
    'required_without' => '当 :values 不存在时，:attribute 字段是必填的。',
    'required_without_all' => '当 :values 都不存在时，:attribute 字段是必填的。',
    'same' => ':attribute 和 :other 必须匹配。',
    'size' => [
        'numeric' => ':attribute 必须是 :size。',
        'file' => ':attribute 必须是 :size 千字节。',
        'string' => ':attribute 必须是 :size 个字符。',
        'array' => ':attribute 必须包含 :size 个项目。',
    ],
    'starts_with' => ':attribute 必须以以下之一开头：:values。',
    'string' => ':attribute 必须是一个字符串。',
    'timezone' => ':attribute 必须是一个有效的时区。',
    'unique' => ':attribute 已经被占用。',
    'uploaded' => ':attribute 上传失败。',
    'url' => ':attribute 必须是一个有效的 URL。',
    'uuid' => ':attribute 必须是一个有效的 UUID。',

    'validation_password_mixed' => ':attribute 必须至少包含一个大写字母和一个小写字母。',
    'validation_password_letters' => ':attribute 必须包含至少一个字母。',
    'validation_password_symbols' => ':attribute 必须包含至少一个符号。',
    'validation_password_numbers' => ':attribute 必须包含至少一个数字。',
    'validation_password_uncompromised' => '给定的 :attribute 出现在数据泄漏中。请选择不同的 :attribute。',

    /*
        |--------------------------------------------------------------------------
        | Custom Validation Language Lines
        |--------------------------------------------------------------------------
        |
        | Here you may specify custom validation messages for attributes using the
        | convention "attribute.rule" to name the lines. This makes it quick to
        | specify a specific custom language line for a given attribute rule.
        |
        */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],


];
