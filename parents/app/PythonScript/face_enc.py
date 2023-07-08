import face_recognition as faceRecognition
import urllib.parse as urlparse
from urllib.parse import parse_qs
from urllib.request import urlretrieve
import numpy as np
import sys
import operator

def main(arg):
    parsed = urlparse.urlparse(arg)
    url = parsed._replace(fragment="").geturl()
    print(url)
    # return url

if __name__ == "__main__":
    main(sys.argv[1])

# if __name__ == "__main__":
#     main(sys)    

# demo_img = faceRecognition.load_image_file('./img/pin.jpg')

# face_locations= faceRecognition.face_locations(demo_img)

# print(face_locations)
