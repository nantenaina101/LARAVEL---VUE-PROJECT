<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    /*
        @Author : Nantenaina
        Get students list
     */
    public function index()
    {
        $students = Student::all();
        $results = count($students) > 0 ? $students : "Aucun enregistrement";
        return response()->json($students, 200);
    }

    /*
        Get one student
     */
    public function findOne($id)
    {
        $student = Student::find($id);
        $result = null;
        $status = 500;
        if ($student) {
            $result = $student;
            $status = 200;
        } else {
            $result = "Aucun étudiant correspondant à cet identifiant";
            $status = 404;
        }
        return response()->json($result, $status);
    }

    /*
        Add one student
     */
    public function save(Request $request)
    {

        $body = $request->all();

        $validator = Validator::make(
            $body,
            [
                "name" => 'required|string|max:20',
                "course" => 'required|string|max:20',
                "email" => 'required|email|max:30',
                "phone" => 'required'
                //"phone" => 'required|digits:20'
            ],
            [
                "name.required" => 'Le nom est obligatoire',
                "name.string" => 'Le nom doit être une chaine de caractères',
                "name.max" => 'Le nom est trop long',
                "course.required" => 'Le cours est obligatoire',
                "course.string" => 'Le cours doit être une chaine de caractères',
                "course.max" => 'Le cours est trop long',
                "email.required" => 'L\'email est obligatoire',
                "email.email" => 'L\'email n\'est pas valide',
                "email.max" => 'L\'email est trop long',
                "phone.required" => 'Le téléphone est obligatoire',

            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    "status" => false,
                    "message" => $validator->messages() //$validator->errors()
                ],
                422
            );
        } else {

            $student = Student::create($body);

            /*Student::create([
                "name" => $request->name,
                "course" => $request->course,
                "email" => $request->email,
                "phone" => $request->phone
            ]);*/

            /*$student = new Student;
            $student->name = $request->name; || $body['name']
            $student->course = $request->course; || $body['course']
            $student->email = $request->email; || $body['email']
            $student->phone = $request->phone; || $body['phone']

            $result = $student->save();*/

            if ($student) {
                return response()->json(
                    [
                        "status" => true,
                        "message" => "Etudiant enregistré avec succès !",
                        "student" => $student
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        "status" => false,
                        "message" => "Quelque chose ne va pas !",
                        "student" => $student
                    ],
                    500
                );
            }
        }
    }

    /*
        Update one student
     */
    public function update(Request $request, int $id)
    {

        $body = $request->all();

        $validator = Validator::make(
            $body,
            [
                "name" => 'required|string|max:20',
                "course" => 'required|string|max:20',
                "email" => 'required|email|max:30',
                "phone" => 'required'
                //"phone" => 'required|digits:20'
            ],
            [
                "name.required" => 'Le nom est obligatoire',
                "name.string" => 'Le nom doit être une chaine de caractères',
                "name.max" => 'Le nom est trop long',
                "course.required" => 'Le cours est obligatoire',
                "course.string" => 'Le cours doit être une chaine de caractères',
                "course.max" => 'Le cours est trop long',
                "email.required" => 'L\'email est obligatoire',
                "email.email" => 'L\'email n\'est pas valide',
                "email.max" => 'L\'email est trop long',
                "phone.required" => 'Le téléphone est obligatoire',

            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    "status" => false,
                    "message" => $validator->messages() //$validator->errors()
                ],
                422
            );
        } else {

            $student = Student::find($id);

            if ($student) {

                $student->update($request->all());

                return response()->json(
                    [
                        "status" => true,
                        "message" => "Etudiant modifié avec succès !"
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        "status" => false,
                        "message" => "Aucun étudiant correspondant à cet identifiant !"
                    ],
                    404
                );
            }
        }
    }

    /*
        Delete one student
     */
    public function destroy($id)
    {
        $student = Student::find($id);
        $result = null;
        $status = 500;
        if ($student) {
            $student->delete();
            $result = "Etudiant supprimé avec succès !";
            $status = 200;
        } else {
            $result = "Aucun étudiant correspondant à cet identifiant";
            $status = 404;
        }
        return response()->json(["student" => $student, "message" => $result, "status" => $status], $status);
    }
}