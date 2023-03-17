<?php

namespace App\Imports;

use App\Models\Brokers;
use App\Models\Deposits;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DepositsImport implements ToCollection, WithHeadingRow, withValidation, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    private $brokerId;

    public function __construct($brokerId)
    {
        $this->brokerId = $brokerId;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $key=>$row) {
            $user = User::where('email', $row['email'])->first();
            $transactionDate = Carbon::instance(Date::excelToDateTimeObject($row['transaction_date']))->format('Y-m-d H:i:s');
                Deposits::create([
                    'amount' => round($row['amount'], 2),
                    'transaction_at' => $transactionDate,
                    'userId' => $user->id,
                    'brokersId' =>  $this->brokerId
                ]);
        }
    }


    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'transaction_date' => 'required|regex:/[0-9]+[.]?[0-9]*/|',
            'amount' => 'required|numeric',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'transaction_date.required' => trans('public.transaction_date_required'),
            'transaction_date.regex' => trans('public.transaction_date_regex'),
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        $this->failures = array_merge($this->failures, $failures);
    }

    public function failures()
    {
        return $this->failures;
    }
}
