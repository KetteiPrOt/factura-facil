<?php

namespace App\Livewire\Forms\Invoices;

use App\Models\Establishments\Establishment;
use App\Models\Establishments\IssuancePoint;
use App\Models\Persons\IdentificationType;
use App\Models\Products\Product;
use App\Rules\Invoices\Create\Discount;
use App\Rules\Model\BelongsTo;
use App\Rules\Model\BelongsToUser;
use App\Rules\String\ExactSizes;
use App\Rules\String\NumericDigits;
use Illuminate\Validation\Rule;
use Livewire\Form;

class StoreForm extends Form
{
    // Invoice information
    public $establishment_id;

    public $issuance_point_id;

    public $issuance_date;

    // Client information
    public $social_reason;

    public $identification;

    public $identification_type_id;

    public $email;

    public $address;

    public $phone_number;

    // Products
    public array $products = [];

    // Pay Methods
    public $pay_method_id;

    protected function rules()
    {
        $today = date('Y-m-d');
        $threeMonthAgo = date('Y-m-d', mktime(date('H'), month: date('n') - 3));
        $finalConsumer = IdentificationType::where('name', 'VENTA A CONSUMIDOR FINAL')->first()->id;
        return [
            // Origin Section
            'establishment_id' => [
                'bail', 'required', 'exists:establishments,id',
                new BelongsToUser(Establishment::class, relationship: 'establishments')
            ],
            'issuance_date' => [
                'required', 'date_format:Y-m-d',
                "after_or_equal:$threeMonthAgo",
                "before_or_equal:$today"
            ],
            'issuance_point_id' => [
                'bail', 'required', 'exists:issuance_points,id',
                new BelongsTo(
                    Establishment::find($this->establishment_id),
                    IssuancePoint::class,
                    relationship: 'issuancePoints'
                )
            ],
            // Client Section
            'identification_type_id' => 'required|integer|exists:identification_types,id',
            'identification' => [
                'bail', "required_unless:identification_type_id,$finalConsumer",
                "exclude_if:identification_type_id,$finalConsumer",
                'string', 'min:10', 'max:13', new NumericDigits, new ExactSizes(10, 13),
            ],
            'social_reason' => [
                "required_unless:identification_type_id,$finalConsumer",
                "exclude_if:identification_type_id,$finalConsumer", 'string', 'max:255',
            ],
            'phone_number' => [
                'bail', "exclude_if:identification_type_id,$finalConsumer", 'string', 'size:10', new NumericDigits,
            ],
            'address' => "string|max:255|exclude_if:identification_type_id,$finalConsumer",
            'email' => [
                "required_unless:identification_type_id,$finalConsumer",
                "exclude_if:identification_type_id,$finalConsumer",
                'string', 'max:255', 'email:rfc,strict',
            ],
            // Details Section
            'products' => 'required|array|max:100',
            'products.*' => 'required|array:id,amount,price,discount|size:4',
            'products.*.id' => [
                'bail', 'required', 'exists:products,id', 'distinct',
                new BelongsToUser(Product::class, relationship: 'products')
            ],
            'products.*.amount' => 'required|integer|min:1|max:9999999',
            'products.*.price' => 'required|decimal:0,2|min:0|max:999999.99',
            'products.*.discount' => [
                'bail', 'required', 'decimal:0,2', 'min:0', 'max:999999.99', new Discount
            ],
            // Payment Methods Section
            'pay_method_id' => 'required|integer|exists:pay_methods,id',
        ];
    }

    protected function validationAttributes()
    {
        return [
            // Origin Section
            'establishment_id' => 'establecimiento',
            'issuance_date' => 'fecha de emisión',
            'issuance_point_id' => 'punto de emisión',
            // Client Section
            'identification_type_id' => 'tipo de identificación',
            'identification' => 'identificación',
            'social_reason' => 'razón social',
            'phone_number' => 'número de teléfono',
            'address' => 'dirección',
            'email' => 'email',
            // Details Section
            'products' => 'productos',
            'products.*' => 'producto #:position',
            'products.*.product_id' => 'producto #:position',
            'products.*.amount' => 'cantidad #:position',
            'products.*.price' => 'precio #:position',
            'products.*.discount' => 'descuento #:position',
            // Payment Methods Section
            'pay_method_id' => 'método de pago'
        ];
    }
}
