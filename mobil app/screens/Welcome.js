import React, {useState} from 'react';
import { StatusBar } from 'expo-status-bar';
import { View, Text, ImageBackground,ScrollView, Image, TextInput, TouchableOpacity, FlatList } from 'react-native';

import { Octicons, Ionicons, Fontisto } from '@expo/vector-icons';
import Icon from 'react-native-vector-icons/Ionicons';

import Cards from './Cards';

import{
    InnerContainer,
    PageTitle,
    SubTitle,
    StyledFormArea,
    StyledButton,
    ButtonText,
    Line,
    WelcomeContainer,
    WelcomeImage,
    Avatar,
    deviceHeight,
    deviceWidth
} from './../compontents/styles';

const Welcome = ({ navigation, route, props }) => {
    const { username, email } = route.params;
    const [city, setCity] = useState('');

    const cities = [
        {
          cityname: 'Beograd',
          image: require('./../assets/img/beograd.jpg'),
        },
        {
          cityname: 'Budapest',
          image: require('./../assets/img/budapest.jpg'),
        },
        {
          cityname: 'Berlin',
          image: require('./../assets/img/berlin.jpg'),
        },
        {
          cityname: 'Paris',
          image: require('./../assets/img/paris.jpg'),
        },
        {
          cityname: 'London',
          image: require('./../assets/img/london.jpg'),
        },
      ];

    return (
        <>
            <StatusBar style='light' />
            <ScrollView>
                <InnerContainer>
                <View>
                    <ImageBackground source={require('./../assets/img/bg.jpg')} style={{height: deviceHeight, width: deviceWidth}} imageStyle={{opacity: 0.6, backgroundColor: "black"}}/>
                    <View style={{ position: 'absolute', paddingVertical: 20, paddingHorizontal: 10, }}>
                            <View style={{ flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center', width: deviceWidth - 20 }}>
                                <Image source={require('./../assets/img/logo-black.png')} style={{ height: 1, width: 1, borderRadius: 50 }} />
                                <Icon name='menu' size={46} color='white'/>
                            </View>
                            <View style={{ paddingHorizontal: 20, marginTop: 100 }}>
                                <Text style={{ color: "white", fontSize: 22, fontWeight: "bold" }}>Keress rá egy városra</Text>
                                <View style={{ flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center', borderRadius: 50, borderWidth: 1, borderColor: 'white', marginTop: 16, paddingHorizontal: 10 }}>
                                    <TextInput value={city} onChangeText={(val) =>setCity(val)} placeholder='Keresés..' placeholderTextColor='white' style={{ paddingHorizontal: 10, color: 'white', fontSize: 16 }} />
                                    <TouchableOpacity onPress={() => navigation.navigate('Details', {cityname: city})}>
                                        <Icon name='search' size={22} color='white' />
                                    </TouchableOpacity>
                                </View>
                                <Text style={{color:'white', fontSize: 25, paddingHorizontal: 10, marginTop: 220, marginBottom: 20}}>Főbb városok</Text>
                                                        <FlatList
                            horizontal
                                data={cities}
                                renderItem={({item}) => (
                                <Cards cityname={item.cityname} image={item.image} navigation={navigation}/>
                                )}
                            />
                            </View>
                        </View>
                </View>
            
                    <WelcomeContainer>
                        <PageTitle welcome={true}>Üdv Haver!</PageTitle>
                        <SubTitle welcome={true}>{username || 'Ezekiel'}</SubTitle>
                        <SubTitle welcome={true}>{email || 'Ezekiel@gmail.com'}</SubTitle>
                        <StyledFormArea>
                            <Avatar resizeMode="cover" source={require('./../assets/img/StormSite.png')} />
                            <Line />
                            <StyledButton onPress={() => { navigation.navigate("Login") }}>
                                <ButtonText>Kijelentkezés</ButtonText>
                            </StyledButton>
                        </StyledFormArea>

                    </WelcomeContainer>
                    </InnerContainer>
                    </ScrollView>
        </>
    );
}

export default Welcome;