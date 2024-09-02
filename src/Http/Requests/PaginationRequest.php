<?php


namespace Cirel\LaravelBasicsAuxs\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaginationRequest extends FormRequest
{


    protected $search = ['bail', 'nullable', 'string', 'max:64'];
    protected $withTrashed = ['bail', 'nullable', 'boolean'];
    protected $page = ['bail', 'nullable', 'integer', 'min:1'];
    protected $perPage = ['bail', 'nullable', 'integer', 'min:1', 'max:100'];
    protected $orderBy = ['bail', 'nullable', 'alpha_dash'];
    protected $order = ['bail', 'nullable', 'in:asc,desc'];
    protected $relationships = ['bail', 'nullable', 'array'];

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'relationships' => $this->relationships,
            'search' => $this->search,
            'withTrashed' => $this->withTrashed,
            'page' => $this->page,
            'perPage' => $this->perPage,
            'orderBy' => $this->orderBy,
            'order' => $this->order
        ];
    }
}
