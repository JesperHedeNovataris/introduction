<h2>Invoices</h2>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Due</th>
                <th>Amount</th>
                @if (isset($invoices->first()->customer_name)) {{-- TODO: Find better solution for this --}}
                <th>Customer</th>
                @endif
            </tr>
            </thead>
            <tbody>
            
            @foreach($invoices as $invoice)
            <tr>
                <td>{{ $invoice->invoice_no}}</td>
                <td>{{ $invoice->invoice_due_at }}</td>
                <td>{{ $invoice->amount}}</td>
                @if (isset($invoice->customer_name))
                <td><a href="/customer/{{ $invoice->customer_id }}">{{ $invoice->customer_name }}</a></td>
                @endif
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>