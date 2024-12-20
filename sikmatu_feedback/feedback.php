<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f9;
    }

    .container {
        width: 80%;
        margin: 20px auto;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    form label, form input, form textarea, form button {
        display: block;
        width: 100%;
        margin-bottom: 15px;
    }

    form input, form textarea, form button {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    form button {
        background: #007BFF;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    form button:hover {
        background: #0056b3;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th, table td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: left;
    }

    table th {
        background-color: #007BFF;
        color: white;
    }

    .star_rating {
        display: flex;
        justify-content: center;
        gap: 8px; /* Beri jarak antar tombol bintang */
        margin-bottom: 15px; /* Beri jarak antara rating bintang dan tombol submit */
    }

    .starRate {
        position: relative; /* Perbaiki positioning */
        display: flex;
        gap: 5px; /* Tambahkan jarak antar bintang */
        align-items: center;
        margin-top: 20px;
        cursor: pointer;
    }

    .starRate .fa-star {
        font-size: 2rem; /* Atur ukuran bintang */
        color: #ccc; /* Warna default bintang */
        transition: color 0.3s ease-in-out; /* Tambahkan efek transisi */
    }

    .starRate .fa-star.highlighted, 
    .starRate .fa-star:hover {
        color: orange; /* Warna saat di-hover */
    }

    .starRate .fa-star.selected {
        color: orange; /* Warna saat dipilih */
    }

    .btnSubmit {
        display: block;
        width: 100%;
        padding: 10px;
        background: #007BFF;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 1rem;
        cursor: pointer;
        margin-top: 20px; /* Jarak antara tombol submit dengan elemen sebelumnya */
    }

    .btnSubmit:hover {
        background: #0056b3;
    }

    </style>
</head>
<body>
    <div class="container">
        <h1>Feedback Form</h1>
        <form id="feedbackForm" action="save_feedback.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="stars">Rating:</label>
            <input type="hidden" id="star-value" name="stars" min="1" max="5" required>
            <div class="starRate">
                <span class="fa fa-star fa-3x" data-star="1"></span>
                <span class="fa fa-star fa-3x" data-star="2"></span>
                <span class="fa fa-star fa-3x" data-star="3"></span>
                <span class="fa fa-star fa-3x" data-star="4"></span>
                <span class="fa fa-star fa-3x" data-star="5"></span> <br>
                <div id="reaction-message" class="reaction-message"></div>
            </div> <br>


            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>

            <button type="submit" class="btnSubmit">Submit</button>
        </form>


    </div>
    <script src="script.js"></script>
    <script>
        const stars = document.querySelectorAll('.starRate .fa-star');
        const starValue = document.getElementById('star-value');
        const reactionMessage = document.getElementById('reaction-message');
        const reactions = [
            "Very Bad 😢",
            "Bad 😞",
            "Okay 😐",
            "Good 😊",
            "Excellent 🤩"
        ];

        stars.forEach((star, index) => {
            // Event hover (mouseover)
            star.addEventListener('mouseover', () => {
                highlightStars(index);
                showReaction(index); // Tampilkan pesan reaksi saat hover
            });

            // Event click (memilih rating)
            star.addEventListener('click', () => {
                starValue.value = index + 1; // Simpan nilai bintang yang dipilih
                lockStars(index); // Kunci tampilan bintang
                showReaction(index); // Tampilkan pesan reaksi saat klik
            });

            // Reset highlight saat mouse keluar (mouseleave)
            star.addEventListener('mouseleave', () => {
                resetStars();
                if (starValue.value > 0) {
                    highlightStars(starValue.value - 1); // Pertahankan highlight bintang yang dipilih
                }
            });
        });

        // Fungsi untuk highlight bintang
        function highlightStars(index) {
            stars.forEach((star, i) => {
                if (i <= index) {
                    star.classList.add('highlighted');
                } else {
                    star.classList.remove('highlighted');
                }
            });
        }

        // Fungsi untuk reset highlight
        function resetStars() {
            stars.forEach(star => star.classList.remove('highlighted'));
        }

        // Fungsi untuk kunci tampilan bintang
        function lockStars(index) {
            stars.forEach((star, i) => {
                if (i <= index) {
                    star.classList.add('selected');
                } else {
                    star.classList.remove('selected');
                }
            });
        }

        // Fungsi untuk menampilkan pesan reaksi
        function showReaction(index) {
            reactionMessage.textContent = reactions[index]; // Ambil pesan berdasarkan indeks
        }

    </script>
</body>
</html>
