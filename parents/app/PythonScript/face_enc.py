import face_recognition as faceRecognition

demo_img = faceRecognition.load_image_file('./img/pin.jpg')

face_locations= faceRecognition.face_locations(demo_img)

print(face_locations)
