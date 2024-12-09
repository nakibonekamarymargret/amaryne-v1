<!-- Example form for adding a new salon (add_salon.php) -->
<form action="save_salon.php" method="POST">
    <div class="form-group">
        <label for="salonName">Salon Name:</label>
        <input type="text" class="form-control" id="salonName" name="salonName" required>
    </div>
    <div class="form-group">
        <label for="salonAddress">Address:</label>
        <input type="text" class="form-control" id="salonAddress" name="salonAddress" required>
    </div>
    <div class="form-group">
        <label for="salonOwner">Owner:</label>
        <input type="text" class="form-control" id="salonOwner" name="salonOwner" required>
    </div>
    <div class="form-group">
        <label for="salonServices">Services:</label>
        <input type="text" class="form-control" id="salonServices" name="salonServices" required>
    </div>
    <button type="submit" class="btn btn-primary">Save Salon</button>
</form>