FROM eclipse-temurin:11

# Installer Gradle
RUN apt-get update && apt-get install -y wget unzip
RUN wget https://services.gradle.org/distributions/gradle-7.6-bin.zip -O gradle.zip \
    && unzip gradle.zip -d /opt \
    && ln -s /opt/gradle-7.6/bin/gradle /usr/bin/gradle

WORKDIR /app
COPY . .

# Compiler l'APK
RUN gradle assembleDebug
