<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\InvoiceResource;
use App\Models\Invoice;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    use HttpResponses;

    public function index(Request $request)
    {
        return InvoiceResource::collection(Invoice::with('user')->get());
    }

    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'type' => 'required|max:1',
            'value' => 'required|numeric|between:1,9999.99',
            'paid' => 'required|numeric|between:0,1',
            'payment_date' => 'nullable',
        ]);

        if ($validator->fails()) {
            return $this->error('Dados inválidos', 422, $validator->errors());
        }

        $created = Invoice::create($validator->validated());

        if ($created) {
            return $this->response('Criado com sucesso', 200, new InvoiceResource($created->load('user')));
        }

        return $this->error('Erro ao criar', 400);
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'type' => 'required|max:1|in:' . implode(',', ['B', 'C', 'P']),
            'value' => 'required|numeric|between:1,9999.99',
            'paid' => 'required|numeric|between:0,1',
            'payment_date' => 'nullable|date_format:Y-m-d H:i:s',
        ]);

        if ($validator->fails()) {
            return $this->error('Dados inválidos', 422, $validator->errors());
        }

        $validated = $validator->validated();

        $updated = $invoice->update([
            'user_id' => $validated['user_id'],
            'type' => $validated['type'],
            'value' => $validated['value'],
            'paid' => $validated['paid'],
            'payment_date' => $validated['paid'] ? $validated['payment_date'] : null,
        ]);

        if ($updated) {
            return $this->response('Atualizado com sucesso', 200, new InvoiceResource($invoice->load('user')));
        }

        return $this->error('Erro ao atualizar', 400);
    }

    public function destroy(Request $request, $id)
    {
        // Your logic to delete an invoice
    }
}
