public function up(): void
{
    Schema::create('rank_rates', function (Blueprint $table) {
        $table->id();
        $table->string('rank_name')->unique(); // Nama rank (misal: Warrior, Elite, dll)
        $table->integer('price')->default(0);  // Harga per bintang/point
        $table->timestamps();
    });
}