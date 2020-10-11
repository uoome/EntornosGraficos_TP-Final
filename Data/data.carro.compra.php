<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH . "db.php");
include_once(DAO_PATH . "dao.usuario.php");
include_once(DAO_PATH . "dao.zapatilla.php");
include_once(DAO_PATH . "dao.lineaCompra.php");

session_start();

class CarroCompra
{
    private $id_carro;
    private $total_carro;
    private $id_usuario;

    protected $cart_contents = array(); // Array de lineas de compra

    function __construct()
    {
        // get the shopping cart array from the session
        $this->cart_contents = !empty($_SESSION['cart_contents']) ? $_SESSION['cart_contents'] : NULL;
        if ($this->cart_contents === NULL) {
            // set some base values
            $this->cart_contents = array('cart_total' => 0, 'total_items' => 0);
        }
    }

    /* GETTERS Y SETTERS */
    function get_id()
    {
        return $this->id_carro;
    }
    function set_id($id)
    {
        $this->id_carro = $id;
    }

    function get_total_carro()
    {
        return $this->total_carro;
    }
    function set_total_carro($tot)
    {
        $this->total_carro = $tot;
    }

    function get_idUsuario()
    {
        return $this->id_usuario;
    }
    function set_idUsuario($idUser)
    {
        $this->id_usuario = $idUser;
    }

    // Ver si va | Trae el usuario desde la DB, con id de usuario presente en la class
    function get_usuario()
    {
        if ($this->id_usuario != null) {
            $userService = new UsuarioService();
            return $userService->getUser($this->id_usuario);
        } else return null;
    }

    /**
     * Contenido Carro: Devuelve los elementos del carro de compras
     * @return array $cart
     */
    public function getContenidoCarro()
    {
        // rearrange the newest first
        $cart = array_reverse($this->cart_contents);

        // remove these so they don't create a problem when showing the cart table
        unset($cart['total_items']);
        unset($cart['cart_total']);

        return $cart;
    }

    // Evaluar, creo que no es necesario
    /**
     * Get cart item: Returns a specific cart item details
     * @param string $row_id
     * @return array
     */
    public function get_item($row_id)
    {
        return (in_array($row_id, array('total_items', 'cart_total'), TRUE) or !isset($this->cart_contents[$row_id]))
            ? FALSE
            : $this->cart_contents[$row_id];
    }

    /**
     * Total Items: Returns the total item count
     * @return int
     */
    public function total_items()
    {
        return $this->cart_contents['total_items'];
    }

    /**
     * Cart Total: Returns the total price
     * @return    int
     */
    public function total()
    {
        return $this->cart_contents['cart_total'];
    }

    /**
     * Insert items into the cart and save it to the session
     * @param LineaCompra $linea
     * @return bool
     */
    function insertLinea(LineaCompra $linea)
    {
        // Si es LineaCompra
        if ($linea instanceof LineaCompra) {
            /* Insert Item */
            // Generar id unico para esta linea
            $rowid = md5($linea->get_idZapatilla());
            // Guardar
            $this->cart_contents[$rowid] = $linea;
            if ($this->saveCarro()) {
                // die("carga de carro correcta");
                return TRUE;
            } else {
                // die("Carga de carro incorrecta");
                return FALSE;} 
        } else {
            // Inconsistencia de datos
            return FALSE;
        }
    }

    /**
     * Actualizar el valor del carro en la session
     * @return bool
     */
    protected function saveCarro()
    {
        $this->cart_contents['total_items'] = $this->cart_contents['cart_total'] = 0;

        foreach ($this->cart_contents as $val) {
            // $key = rowID | $val = LineaCompra            
            // echo $key . " -> "; var_dump($val); echo "<br>";
            // Si es LineaCompra, actualizar carro
            if ($val instanceof LineaCompra) {
                $this->cart_contents['cart_total'] += $val->get_subtotalLinea();
                $this->cart_contents['total_items'] += $val->get_qty(); 
            }
        }
        // var_dump($this->cart_contents); echo "<br>";
        // die(print(sizeof($this->cart_contents)));
        // if cart empty (size = 2 elements), delete it from the session
        if (count($this->cart_contents) <= 2) {
            // die("Menos de 2");
            unset($_SESSION['cart_contents']);
            return FALSE;
        } else {
            // die("Mas de 2");
            $_SESSION['cart_contents'] = $this->cart_contents;
            return TRUE;
        }
    }

    /**
     * Actualizar carro: Actualiza los valores del carro de compra para un item determinado
     * @param string $ri 
     * @param int $q 
     * @return bool
     */
    public function actualizarCarro($ri, $q)
    {
        // Si las variables no estan seteadas -> False
        if(!isset($ri) || !isset($q)) {
            return FALSE;
        } else {
            // Remover item del carro si la cantidad es '0'
            if($q == 0) return $this->remover($ri);
            else {
                // Actualizar cantidad
                $element = $this->cart_contents[$ri];
                if ($element instanceof LineaCompra) {
                    $element->set_qty($q);
                    $element->set_subtotalLinea($q * $element->get_subtotalLinea());
                    // Actualizar carro
                    return $this->saveCarro();
                } else return FALSE;
            }
        }
    }

    /**
     * Remover Item: Quita el item del carro de compra
     * @param int $row_id
     * @return bool
     */
    public function remover($row_id)
    {
        // unset & save
        unset($this->cart_contents[$row_id]);
        return $this->saveCarro();
    }

    /**
     * Destruir el carro: Vacia el carro de compra y lo destruye de la sesion
     * @return void
     */
    public function destruirCarro()
    {
        $this->cart_contents = array('cart_total' => 0, 'total_items' => 0);
        unset($_SESSION['cart_contents']);
    }
}
