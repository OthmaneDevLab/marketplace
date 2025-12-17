<form method="POST" action="/become-vendor">
    @csrf

    <label>Store Name</label>
    <input name="store_name" required>

    <label>Description</label>
    <textarea name="description"></textarea>

    <button type="submit">Submit Application</button>
</form>
