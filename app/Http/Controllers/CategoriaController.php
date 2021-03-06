<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\Producto;
class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categoria::paginate(6);
        return view('listadoCategorias', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $categorias = Categoria::all();
        return view('cargarCategorias', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reglas = [
            'nombre' => 'required|string'
            ];

        $errors = [
            'required' => 'El campo :attribute es requerido',
            'string' => 'El campo :attribute debe ser un texto'
        ];

        $this->validate($request, $reglas, $errors);

                $categoria = new Categoria();
                $categoria->nombre = $request['nombre'];
                $categoria->save();

                return redirect('/admin/categoria')->with(compact('categoria'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($categorium)
    {
        // $categoria = Categoria::find($categorium);
        // return view('editarCategorias', compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($categorium)
    {
        $categoria = Categoria::find($categorium);
        return view('editarCategorias', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $categorium)
    {
        
        $categoria = Categoria::find($categorium);
        
        $categoria->nombre = $request['nombre'];        
        $categoria->save();
    return redirect('/admin/categoria')->with(compact("categoria"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($categorium)
    {
        
        $productos = Producto::all();
        foreach ($productos as $item ) {
            if ($item->categoria_id == $categorium) {
                $mensaje = "La categoria no se puede eliminar ya que tiene productos asignados";
                return redirect('/admin/categoria')->with(compact('mensaje')); 
            }
        }
        $categoria = Categoria::find($categorium);
        $categoria->delete();
        return redirect('/admin/categoria');  
    }
}
