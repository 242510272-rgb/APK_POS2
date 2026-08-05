@if (!empty($produk->foto))
    <div class="mb-2">
        <label class="form-label">Foto Saat Ini</label><br>
        <img src="{{ asset('storage/'. $produk->foto) }}" width="150" class="img-thumbnail">
    </div>
@endif

<div class="row mb-3">
    <div class="col">
        <div>
            <label class="form-label">Gambar</label>
            <input type="file" 
                   name="foto" 
                   onchange="previewImage(this)"
                   class="form-control @error('foto') is-invalid @enderror">
            @error('foto')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="mb-2">
        <img id="preview" class="img-thumbnail mt-2" style="display:none" width="150">
    </div>
</div>

<!-- Dropdown Jenis Produk -->
<div class="mb-3">
    <label class="form-label">Jenis Produk</label>
    <select name="jenis_id" class="form-select @error('jenis_id') is-invalid @enderror">
        <option value="">-- Pilih Jenis Produk --</option>
        @foreach($jenis as $j)
            <option value="{{ $j->id }}" {{ old('jenis_id', $produk->jenis_id ?? '') == $j->id ? 'selected' : '' }}>
                {{ $j->nama_jenis }}
            </option>
        @endforeach
    </select>
    @error('jenis_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<!-- Nama Produk -->
<div class="mb-3">
    <label class="form-label">Nama Produk</label>
    <input type="text" name="name"
           class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $produk->nama ?? '') }}">
    @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<!-- Harga Beli -->
<div class="mb-3">
    <label class="form-label">Harga Beli</label>
    <input type="number" name="purchase_price"
           class="form-control @error('purchase_price') is-invalid @enderror"
           value="{{ old('purchase_price', $produk->harga_beli ?? '') }}">
    @error('purchase_price')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<!-- Harga Jual -->
<div class="mb-3">
    <label class="form-label">Harga Jual</label>
    <input type="number" name="selling_price"
           class="form-control @error('selling_price') is-invalid @enderror"
           value="{{ old('selling_price', $produk->harga_jual ?? '') }}">
    @error('selling_price')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<!-- Stok -->
<div class="mb-3">
    <label class="form-label">Stok</label>
    <input type="number" name="stock"
           class="form-control @error('stock') is-invalid @enderror"
           value="{{ old('stock', $produk->stok ?? '') }}">
    @error('stock')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<button class="btn btn-success mt-3" type="submit">Simpan</button>
<a href="{{ route('produk.index') }}" class="btn btn-secondary mt-3">Kembali</a>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    const file = input.files[0];

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
}
</script>