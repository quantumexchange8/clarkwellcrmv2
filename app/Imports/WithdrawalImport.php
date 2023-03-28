<?php

namespace App\Imports;

use App\Models\Deposits;
use App\Models\User;
use App\Models\Withdrawals;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
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

class WithdrawalImport implements ToCollection, WithHeadingRow, withValidation, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        dd($rows);
        foreach ($rows as $key=>$row) {

            $user = User::where('email', $row['email'])->first();
            $transactionDate = Carbon::instance(Date::excelToDateTimeObject($row['transaction_date']))->format('Y-m-d H:i:s');
            $perform_action = true;
            $type = Deposits::TYPE_DEPOSIT;

            if ($row['type'] == Deposits::TYPE_WITHDRAW) {
                $capital_available_in_broker = $user->withdrawalAmountValidationByBrokers($this->brokerId)->first();
                $capital_available_in_broker = $capital_available_in_broker->amount ?? 0;
                $type = Deposits::TYPE_WITHDRAW;
                if ($row['amount'] > $capital_available_in_broker) {
                    $perform_action = false;
                    $failures[] = new Failure($key+2, 'amount', [trans('public.invalid_action') . ', ' . trans('public.insufficient_amount')], $row->toArray());
                    $this->failures = array_merge($this->failures, $failures);
                }
            }
            if ($perform_action) {
                Withdrawals::create([
                    'network' => $request->network,
                    'amount' => $amount,
                    'address' => $request->address,
                    'transaction_fee' => $fee,
                    'status' => Withdrawals::STATUS_PENDING,
                    'requested_by_user' => $user->id,
                ]);
            }
        }
    }


    public function rules(): array
    {

        return [
            'email' => 'required|email|exists:users,email',
            'network' =>  ['required', Rule::in([Deposits::TYPE_DEPOSIT, Deposits::TYPE_WITHDRAW])],
            'amount' => ['required', 'numeric',],
        ];
    }

    public function customValidationMessages()
    {
        return [

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
