<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
  
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
           'product-list',
           'product-create',
           'product-edit',
           'product-delete',
           'blog-list',
           'blog-create',
           'blog-edit',
           'blog-delete',
           'blogcategory-list',
           'blogcategory-create',
           'blogcategory-edit',
           'blogcategory-delete',
           'news-list',
           'news-create',
           'news-edit',
           'news-delete',
           'newscategory-list',
           'newscategory-create',
           'newscategory-edit',
           'newscategory-delete',
           'pages-list',
           'pages-create',
           'pages-edit',
           'pages-delete',
           'module-list',
           'module-create',
           'module-edit',
           'module-delete',
        ];
        
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
