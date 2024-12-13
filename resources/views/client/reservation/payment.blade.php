<x-app-layout>


@section('content')
    <h1>Paiement</h1>

    <form action="{{ route('client.payment.store') }}" method="POST">
        @csrf
        <div>
            <label for="reservation_id">ID Réservation :</label>
            <input type="text" id="reservation_id" value="{{ $reservation->id }}" readonly>
            <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
        </div>

        <div>
            <label for="amount">Montant :</label>
            <input type="text" id="amount" value="{{ $reservation->price }}" readonly>
            <input type="hidden" name="amount" value="{{ $reservation->price }}">
        </div>

        <div>
            <label for="payment_method">Méthode de paiement :</label>
            <select id="payment_method" name="payment_method" required>
                <option value="card">Carte Bancaire</option>
                <option value="cash">Espèces</option>
                <option value="paypal">PayPal</option>
            </select>
        </div>

        <div id="card-info" style="display: none;">
            <label for="card_number">Numéro de carte :</label>
            <input type="text" id="card_number" name="card_number">

            <label for="expiry_date">Date d’expiration :</label>
            <input type="month" id="expiry_date" name="expiry_date">

            <label for="cvv">CVV :</label>
            <input type="text" id="cvv" name="cvv">
        </div>

        <button type="submit">Confirmer le Paiement</button>
    </form>

    <script>
        document.getElementById('payment_method').addEventListener('change', function () {
            const cardInfo = document.getElementById('card-info');
            if (this.value === 'card') {
                cardInfo.style.display = 'block';
            } else {
                cardInfo.style.display = 'none';
            }
        });
    </script>
@endsection
</x-app-layout>
