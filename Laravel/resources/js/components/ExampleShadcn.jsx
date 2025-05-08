import React from 'react';
import { createRoot } from 'react-dom/client';

export default function ExampleShadcn() {
    return (
        <div className="max-w-7xl mx-auto p-6">
            <h1 className="text-3xl font-bold mb-6">Ejemplo con Tailwind CSS</h1>
            
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div className="rounded-xl border bg-white p-6 shadow">
                    <div className="flex flex-col space-y-1.5 pb-4">
                        <h3 className="font-semibold text-xl">Tarjeta de ejemplo</h3>
                        <p className="text-gray-500 text-sm">Este es un ejemplo de una tarjeta</p>
                    </div>
                    <div>
                        <p>Aquí puedes incluir el contenido principal de tu tarjeta.</p>
                    </div>
                    <div className="flex justify-between pt-4">
                        <button className="rounded-md border px-4 py-2 text-sm">Cancelar</button>
                        <button className="rounded-md bg-blue-600 text-white px-4 py-2 text-sm">Enviar</button>
                    </div>
                </div>
                
                <div className="rounded-xl border bg-white p-6 shadow">
                    <div className="flex flex-col space-y-1.5 pb-4">
                        <h3 className="font-semibold text-xl">Características</h3>
                        <p className="text-gray-500 text-sm">Ventajas de usar Tailwind CSS</p>
                    </div>
                    <div>
                        <ul className="list-disc list-inside space-y-2">
                            <li>Componentes accesibles</li>
                            <li>Personalizable con clases</li>
                            <li>Sin estilos predeterminados</li>
                            <li>Código abierto</li>
                        </ul>
                    </div>
                    <div className="pt-4">
                        <button className="w-full rounded-md bg-gray-200 px-4 py-2 text-sm">Más información</button>
                    </div>
                </div>
                
                <div className="rounded-xl border bg-white p-6 shadow">
                    <div className="flex flex-col space-y-1.5 pb-4">
                        <h3 className="font-semibold text-xl">Variantes de botones</h3>
                        <p className="text-gray-500 text-sm">Tailwind CSS ofrece muchas opciones</p>
                    </div>
                    <div className="flex flex-col gap-2">
                        <button className="rounded-md bg-blue-600 text-white px-4 py-2 text-sm">Principal</button>
                        <button className="rounded-md bg-gray-200 px-4 py-2 text-sm">Secundario</button>
                        <button className="rounded-md border px-4 py-2 text-sm">Outline</button>
                        <button className="rounded-md bg-red-600 text-white px-4 py-2 text-sm">Destructivo</button>
                        <button className="rounded-md hover:bg-gray-100 px-4 py-2 text-sm">Ghost</button>
                        <button className="text-blue-600 underline px-4 py-2 text-sm">Link</button>
                    </div>
                </div>
            </div>
        </div>
    );
}

if (document.getElementById('example-shadcn')) {
    const root = createRoot(document.getElementById('example-shadcn'));
    root.render(<ExampleShadcn />);
} 