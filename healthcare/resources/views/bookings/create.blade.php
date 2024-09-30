<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discount Module Development for Booking System</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <script>
        function updateDiscount() {
            const discountSelect = document.getElementById('discount_id');
            const discountValueDisplay = document.getElementById('discount_value');
            const discountTypeDisplay = document.getElementById('discount_type');
            const totalCostDisplay = document.getElementById('total_cost');
            const baseFeeDisplay = document.getElementById('base_fee_display');

            const baseCost = parseFloat(document.getElementById('base_cost').value) || 0;
            baseFeeDisplay.innerText = baseCost.toFixed(2); // Update base fee display

            const selectedOption = discountSelect.options[discountSelect.selectedIndex];
            const discountId = selectedOption.value;

            if (discountId) {
                const discountValue = parseFloat(selectedOption.dataset.value);
                const discountType = selectedOption.dataset.type;
                const discountName = selectedOption.text; // Use the text of the selected option as the discount name

                let finalCost = baseCost;
                if (discountType === 'percentage') {
                    finalCost = baseCost - (baseCost * discountValue / 100);
                    discountTypeDisplay.innerText = discountName; // Display discount name here
                } else if (discountType === 'amount') {
                    finalCost = baseCost - discountValue;
                    discountTypeDisplay.innerText = discountName; // Display discount name here
                }
                discountValueDisplay.innerText = (baseCost - finalCost).toFixed(2); // Show the discount applied
                totalCostDisplay.innerText = finalCost.toFixed(2); // Show final cost
            } else {
                discountValueDisplay.innerText = '0.00';
                discountTypeDisplay.innerText = '--';
                totalCostDisplay.innerText = baseCost.toFixed(2);
            }
        }
    </script>
    <style>
        .card {
            padding: 16px !important;
            border-radius: 31px !important;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
            transition: transform .2s;
            /* Animation */
        }

        .card:hover {
            transform: scale(0.99);
            box-shadow: none;
        }

        h3 {
            color: #28a745;
        }

        @media only screen and (min-width: 600px) {
            body {
                display: flex;
                align-items: center;
                justify-content: center;
                background-image: linear-gradient(1deg, #63e380, transparent);
                background-repeat: no-repeat !important;
                height: 100vh;

            }

        }

        @media only screen and (max-width: 600px) {
            body {
                background-repeat: no-repeat !important;
                background-image: linear-gradient(1deg, #63e380, transparent);
               padding: 10px;
            }
        }
    </style>

    <div class="card">
        <center>
            <h3>HEALTHCARE APPOINTMENT  </h3>
        </center>

        @if (session('success'))
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        <form action="{{ route('bookings.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <div class="row">
                    <div class="col-sm">
                        <label for="user_id">Select User:</label>
                        <select name="user_id" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm">
                        <label for="doctor_id">Select Doctor:</label>
                        <select name="doctor_id" required>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

            </div>



            <div class="form-group">
                <div class="row">
                    <div class="col-sm">
                        <label for="appointment_date">Select Date and Time:</label>
                        <input type="datetime-local" name="appointment_date" required>
                    </div>
                    <div class="col-sm">
                        <label for="base_cost">Enter Base Cost:</label>
                        <input type="number" id="base_cost" name="base_cost" value="100" step="0.01" required>
                    </div>
                </div>

            </div>



            <div class="form-group">
                <div class="row">
                    <div class="col-sm">
                        <label for="discount_id">Apply Discount (optional):</label>
                        <select name="discount_id">
                            <option value="">-- No Discount --</option>
                            @foreach ($discounts as $discount)
                                <option value="{{ $discount->id }}">{{ $discount->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm">
                        <div class="summary billing">
                            <h3>Billing Summary</h3>
                            <table>
                                <tr>
                                    <td>Discount Type:</td>
                                    <td><span id="discount_type">--</span></td>
                                </tr>
                                <tr>
                                    <td>Base Fee:</td>
                                    <td>₹<span id="base_fee_display">100.00</span></td>
                                </tr>
                                <tr>
                                    <td>Discount Amount:</td>
                                    <td>- ₹<span id="discount_value">0</span></td>
                                </tr>
                                <tr class="total-row">
                                    <td><strong>Total Payable:</strong></td>
                                    <td><strong>₹<span id="total_cost">100.00</span></strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

            </div>


            <button type="submit">Book Now</button>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
