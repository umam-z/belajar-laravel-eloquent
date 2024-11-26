<?php

namespace Tests\Feature;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertTrue;

class CategoryTest extends TestCase
{
    /**
     * Oloquent Insert
     */
    public function testInsert(): void
    {
        $category = new Category();
        $category->id = 'GADGET';
        $category->name = 'Gadget';
        $result = $category->save();

        assertTrue($result);
    }

    /**
     * Oloquent Insert Many
     */
    public function testInsertMany(): void
    {
        $categories = [];

        for ($i=0; $i < 10; $i++) { 
            $categories[] = [
                'id'=>"ID-$i",
                'name'=>"Category-$i"
            ];
        }

        // $result = Category::query()->insert($categories);
        $result = Category::insert($categories);
        assertTrue($result);

        $total = Category::count();
        assertEquals(10, $total);
    }

    /**
     * Oloquent Find
     */
    public function testFind(): void {
        $this->seed(CategorySeeder::class);

        $category = Category::query()->find('FOOD');
        assertNotNull($category);
        assertEquals('FOOD', $category->id);
        assertEquals('Food', $category->name );
        assertEquals('Food Category', $category->description);
    }

    /**
     * Oloquent Update
     */
    public function testUpdate(): void {
        $this->seed(CategorySeeder::class);

        $category = Category::query()->find('FOOD');

        $category->name = 'Food Update';

        $result = $category->update();
        assertTrue($result);
    }

    /**
     * Oloquent Select
     */
    public function testSelect(): void {
        
        for ($i=0; $i < 10 ; $i++) { 
            $category = new Category();
            $category->id = "CATEGORY-$i";
            $category->name = "Category-$i";
            $category->save();
        }

        $categories = Category::query()->whereNull('description')->get();
        assertEquals(10, $categories->count());

        $categories->each(function($category){
            $category->description = 'updated';
            $category->update();
        });
    }

    /**
     * Oloquent Update Many
     */
    public function testUpdateMany(): void {
        
        // penyimpanan data-data category
        $categories = [];

        for ($i=0; $i < 10 ; $i++) { 
            // assign data 10 biji kedalam penyimpanan
            $categories[] = [
                'id'=>$i,
                'name'=> "Category-$i"
            ];
        }

        // setelah sepuluh data masuk pindah ke database
        $result = Category::query()->insert($categories);
        // pastikan hasilnya true
        assertTrue($result);

        // update data category yang telah dipindah ke database
        Category::query()->whereNull('description')->update(['description'=>'Updated']);
        
        // hitung jumlah data yang telah diupdate
        $total = Category::query()->where('description', '=', 'Updated')->count();
        //pastikan jumlah data yang telah diupdate sesuai
        assertEquals(10, $total);
    }

    /**
     * Oloquent Delete
     */
    public function testDelete():void {
        // insert melalui seeder
        $this->seed(CategorySeeder::class);

        // cari data yang telah dimasukkan
        $category = Category::query()->find('FOOD');
        // hapus
        $result = $category->delete();

        // pastikan true
        assertTrue($result);

        // karena data yang dimasukkan 1 dan data tsb dihapus maka ketika di hitung hasilnya 0
        $total = Category::query()->count();
        // pastikan totalnya adalah kosong
        assertEquals(0, $total);
    }

    /**
     * Oloquent Delete Many
     */
    public function testDeleteMany(): void {
        
        // penyimpanan data-data category
        $categories = [];

        for ($i=0; $i < 10 ; $i++) { 
            // assign data 10 biji kedalam penyimpanan
            $categories[] = [
                'id'=>$i,
                'name'=> "Category-$i"
            ];
        }

        // setelah sepuluh data masuk pindah ke database
        $result = Category::query()->insert($categories);
        // pastikan hasilnya true
        assertTrue($result);

        // hitung jumlah data yang telah dimasukkan
        $total = Category::query()->count();
        //pastikan jumlah data yang telah dimasukkan sesuai
        assertEquals(10, $total);

        
        Category::query() // query ke database
        ->whereNull('description') // cari semua value null yang ada pada colom description
        ->delete(); // semua data yang telah ditemukan hapus
        
        // hitung jumlah data yang telah dihapus
        $total = Category::query()->count();
        //pastikan jumlah data yang telah dihapus sesuai
        assertEquals(0, $total);
    }

    /**
     * Oloquent Fillable Create
     */
    public function testCreate(): void {
        $request = [
            'id' => 'FOOD',
            'name' => 'Food',
            'description' => 'Food Category',
        ];

        $category = new Category($request);
        $category->save();
        assertNotNull($category->id);
    }

    /**
     * Oloquent Fillable Create Method
     */
    public function testCreateMethod(): void {
        $request = [
            'id' => 'FOOD',
            'name' => 'Food',
            'description' => 'Food Category',
        ];

        $category = Category::query()->create($request);
        assertNotNull($category->id);
    }

    /**
     * Eloquent Mass Update
     */
    public function testUpdateMass(): void {
        $this->seed(CategorySeeder::class);

        $request = [
            'name'=>'Food Updated',
            'description'=>'Food Category Updated',
        ];

        $result = Category::query()->find('FOOD')->fill($request)->save();
        assertTrue($result);
    }
}
