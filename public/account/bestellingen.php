<!-- PHP logica -->
<?php include __DIR__ . '/../../application/account/services.php'; ?>
<?php include_once __DIR__ . '/../../application/DatabaseManager.php';?>

<!DOCTYPE html>

<html lang="en">
<!--Head-->
<?php include __DIR__ . "/../../application/components/layout/head.php"; ?>

<body class="min-vw-100 min-vh-100 d-flex flex-column bg-white">
<!--Header-->
<?php include __DIR__ . "/../../application/components/layout/header.php"; ?>
<!--Header-->
<?php include __DIR__ . '/../../application/account/menu.php'; ?>
<!--Pagina content container--><div class="container mt-5 text-center"></div>

<!-- Container voor de titel en zoekbalk, gecentreerd op de pagina -->

<div class="container">
    <!-- Titel boven de zoekbalk met ondermarge voor ruimte -->
    <div class="row justify-content-center">
        <div class="col-12 text-center mb-3"> <!-- mb-3 voegt ruimte toe onder de titel -->
            <h2>Bestelling zoeken</h2>
        </div>
    </div>
    <!-- Zoekbalk in het midden van de pagina -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" name="search" id="header-search"
                       placeholder="Bestelling zoeken"
                       aria-label="Bestelling zoeken."
                       aria-describedby="addon-wrapping"
                       class="form-control border text-center">
                <button class="btn btn-outline-light border text-dark" type="button">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<?php $bestellingen = haalBestellingenOpVanKlant(klantId:2); // Haal de bestellingen op. ?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Bestelling Overzicht</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <?php if (!empty($bestellingen)): ?>
        <table class="table">
            <thead>
            <tr>
                <th>Bestelling ID</th>
                <th>Besteldatum</th>
                <th>Product</th>
                <th>Totaal</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($bestellingen as $bestelling): ?>
                <tr>
                    <td><?php echo htmlspecialchars($bestelling['bestelling_id']); ?></td>
                    <td><?php echo htmlspecialchars($bestelling['besteldatum']); ?></td>
                    <td><?php echo htmlspecialchars($bestelling['productnaam']); ?></td>
                    <td>€<?php echo htmlspecialchars(number_format($bestelling['totaal'], 2, ',', '.')); ?></td>

                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    <?php else: ?>
        <p>Geen bestellingen gevonden.</p>
    <?php endif; ?>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

<!--Footer & Scripts-->
<?php include __DIR__ . "/../../application/components/layout/footer.php"; ?>
<?php include __DIR__ . "/../../application/components/layout/scripts.php"; ?>

</body>
</html>