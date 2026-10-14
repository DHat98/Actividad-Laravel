<?php

use App\Models\Curso;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Grupo;
use App\Models\Matricula;

test('puede crear un grupo con dos estudiantes matriculados', function () {
    // 1. Crear las entidades base
    $curso = Curso::factory()->create();
    $docente = Docente::factory()->create();
    
    // 2. Crear el grupo asociado al curso y docente
    $grupo = Grupo::factory()->create([
        'curso_id' => $curso->id,
        'docente_id' => $docente->id,
    ]);

    // 3. Crear dos estudiantes
    $estudiante1 = Estudiante::factory()->create();
    $estudiante2 = Estudiante::factory()->create();

    // 4. Matricular a los estudiantes en el grupo
    Matricula::create([
        'estudiante_id' => $estudiante1->id,
        'grupo_id' => $grupo->id,
        'fecha' => now(),
        'notaFinal' => 4.5,
    ]);

    Matricula::create([
        'estudiante_id' => $estudiante2->id,
        'grupo_id' => $grupo->id,
        'fecha' => now(),
        'notaFinal' => 3.0,
    ]);

    // 5. Verificar que el grupo tiene exactamente 2 estudiantes matriculados
    expect($grupo->estudiantes)->toHaveCount(2);
    
    // Verificar que los estudiantes están correctamente asociados
    expect($grupo->estudiantes->pluck('id'))->toContain($estudiante1->id, $estudiante2->id);
});