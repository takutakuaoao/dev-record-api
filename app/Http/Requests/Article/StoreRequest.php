<?php

declare(strict_types=1);

namespace App\Http\Requests\Article;

use App\Http\Response\ErrorResponse;
use App\Rules\NotArrayRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    private static $publicTypes = [
        'public' => 1,
        'draft'  => 2,
    ];

    private const CATEGORY_ID_FIELD  = 'categoryId';
    private const TITLE_FIELD        = 'title';
    private const CONTENT_FIELD      = 'content';
    private const SLUG_FIELD         = 'slug';
    private const MAIN_IMG_URL_FILED = 'mainImgUrl';
    private const TYPE_FIELD         = 'type';

    public static function makeRequest($categoryId, $title, $content, $slug, $mainImgUrl, $type): array
    {
        return [
            static::CATEGORY_ID_FIELD  => $categoryId,
            static::TITLE_FIELD        => $title,
            static::CONTENT_FIELD      => $content,
            static::SLUG_FIELD         => $slug,
            static::MAIN_IMG_URL_FILED => $mainImgUrl,
            static::TYPE_FIELD         => $type,
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $firstRule = $this->type() == self::$publicTypes['public'] ? 'required' : 'nullable';

        return [
            static::CATEGORY_ID_FIELD  => [$firstRule, new NotArrayRule, 'exists:categories,id'],
            static::TITLE_FIELD        => [$firstRule, new NotArrayRule, 'max:100'],
            static::CONTENT_FIELD      => [$firstRule, new NotArrayRule],
            static::SLUG_FIELD         => [$firstRule, new NotArrayRule, 'max:100'],
            static::MAIN_IMG_URL_FILED => ['nullable', new NotArrayRule, 'max:2000'],
            static::TYPE_FIELD         => ['required', new NotArrayRule, Rule::in(static::$publicTypes)],
        ];
    }

    public function messages()
    {
        return [
            'required' => '記事を公開する場合は:attributeが必須です',
            'max'      => [
                'string' => ':attributeを:max文字以内で入力してください',
            ],
            'in'     => ':attributeの値が不正です',
            'exists' => '存在しない:attributeが設定されています',
        ];
    }

    public function attributes()
    {
        return [
            static::CATEGORY_ID_FIELD  => 'カテゴリ',
            static::CONTENT_FIELD      => 'コンテンツ',
            static::TITLE_FIELD        => 'タイトル',
            static::SLUG_FIELD         => 'スラッグ',
            static::MAIN_IMG_URL_FILED => 'メイン画像のURL',
            static::TYPE_FIELD         => '公開タイプ',
        ];
    }

    public function categoryId()
    {
        return request()->input(static::CATEGORY_ID_FIELD);
    }

    public function content()
    {
        return request()->input(static::CONTENT_FIELD);
    }

    public function title()
    {
        return request()->input(static::TITLE_FIELD);
    }

    public function slug()
    {
        return request()->input(static::SLUG_FIELD);
    }

    public function mainImgUrl()
    {
        return request()->input(static::MAIN_IMG_URL_FILED);
    }

    public function type()
    {
        return request()->input(static::TYPE_FIELD);
    }

    protected function failedValidation(Validator $validator)
    {
        $errorMessages = [];
        foreach ($validator->errors()->toArray() as $itemName => $messages) {
            $errorMessages[$itemName] = is_array($messages) ? $messages[0] : $messages;
        }

        $res = response()->json(
            (new ErrorResponse($status = 400, $errorMessages))->toArray(),
            $status,
        );

        throw new HttpResponseException($res);
    }
}
