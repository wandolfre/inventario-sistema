<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Producto;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Productos extends Component
{
    use WithPagination;

    // Add the __invoke method here - right after the class declaration
    //public function __invoke()
    //{
    //    return $this->render();
    //}

    public $nombre, $codigo, $descripcion, $cantidad, $precio;
    public $producto_id; // For identifying the product being edited
    public $editando = false; // Flag for edit mode
    public $buscar = ''; // Property for search input

    // Properties for product details modal (Declared once here)
    public $mostrarModal = false;
    public $productoSeleccionado = []; // Will store the selected product data

    // This makes the 'buscar' property appear in the URL query string
    protected $updatesQueryString = ['buscar'];

    // This method is called whenever the 'buscar' property is updated
    public function updatingBuscar()
    {
        $this->resetPage(); // Reset pagination to the first page when a new search is performed
    }

    public function guardarProducto()
    {
        $this->validate([
            'nombre' => 'required|string|max:255', // Added string|max:255 for better validation
            'codigo' => 'required|string|max:255|unique:productos,codigo,' . $this->producto_id, // Changed to 'productos' table
            'cantidad' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0',
        ]);

        if ($this->editando) {
            $producto = Producto::find($this->producto_id); // Changed from Product to Producto
            $producto->update([
                'nombre' => $this->nombre,
                'codigo' => $this->codigo,
                'descripcion' => $this->descripcion,
                'cantidad' => $this->cantidad,
                'precio' => $this->precio,
            ]);
            session()->flash('mensaje', 'Producto actualizado con éxito.');
        } else {
            Producto::create([ // Changed from Product to Producto
                'nombre' => $this->nombre,
                'codigo' => $this->codigo,
                'descripcion' => $this->descripcion,
                'cantidad' => $this->cantidad,
                'precio' => $this->precio,
            ]);
            session()->flash('mensaje', 'Producto creado con éxito.');
        }

        $this->resetCampos(); // Clear form fields
        $this->resetPage(); // Reset pagination to ensure the new/updated product is visible
    }

    public function editarProducto($id)
    {
        $producto = Producto::find($id); // Changed from Product to Producto
        $this->producto_id = $producto->id;
        $this->nombre = $producto->nombre;
        $this->codigo = $producto->codigo;
        $this->descripcion = $producto->descripcion;
        $this->cantidad = $producto->cantidad;
        $this->precio = $producto->precio;
        $this->editando = true;
    }

    public function cancelarEdicion()
    {
        $this->resetCampos();
    }

    public function eliminarProducto($id)
    {
        Producto::destroy($id); // Changed from Product to Producto
        session()->flash('mensaje', 'Producto eliminado con éxito.');
        $this->resetPage(); // Reset pagination to reflect the deletion
    }

    public function eliminar($id)
    {
        if (Auth::user()->role !== 'admin') { // Changed from 'rol' to 'role' (check your user table column name)
            abort(403, 'Acción no autorizada');
        }

        Producto::find($id)->delete(); // Changed from Product to Producto
    }

    // This method opens the product details modal
    public function verDetalles($id)
    {
        $producto = Producto::find($id);
        
        if ($producto) {
            $this->productoSeleccionado = [
                'nombre' => $producto->nombre,
                'codigo' => $producto->codigo,
                'precio' => $producto->precio,
                'cantidad' => $producto->cantidad,
                'descripcion' => $producto->descripcion,
            ];
            $this->mostrarModal = true;
        }
    }

    // This method closes the product details modal
    public function cerrarModal()
    {
        $this->mostrarModal = false; // Hide the modal
        $this->productoSeleccionado = []; // Clear selected product data
    }

    private function resetCampos()
    {
        $this->reset(['nombre', 'codigo', 'descripcion', 'cantidad', 'precio', 'producto_id', 'editando']);
    }

    public function render()
    {
        $productos = Producto::where('nombre', 'like', '%' . $this->buscar . '%')
            ->orWhere('codigo', 'like', '%' . $this->buscar . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.productos', [
        'productos' => $productos
        ])->layout('layouts.app'); // 👈 Aquí cambias de 'components.layouts.app' a 'layouts.app'
    }
}