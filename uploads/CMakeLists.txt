cmake_minimum_required(VERSION 3.10)
project(mouse-mapper)

set(CMAKE_CXX_STANDARD 11)
set(CMAKE_CXX_STANDARD_REQUIRED ON)

find_package(PkgConfig REQUIRED)
pkg_check_modules(GTK3 REQUIRED gtk+-3.0)

# Füge X11 hinzu
find_package(X11 REQUIRED)

add_executable(mouse-mapper src/main.cpp)
target_include_directories(mouse-mapper PRIVATE ${GTK3_INCLUDE_DIRS} ${X11_INCLUDE_DIRS})
target_link_libraries(mouse-mapper PRIVATE ${GTK3_LIBRARIES} ${X11_LIBRARIES})
