import { View, Text, ImageBackground, Image } from "react-native";
import React,  { useEffect, useState } from "react";

import { API_KEY } from './Constants';
import { StatusBar } from 'expo-status-bar';

import { deviceWidth, deviceHeight } from "../compontents/styles";

import Icon from 'react-native-vector-icons/Ionicons';



export default function Details(props) {
    const [data, setData] = useState();
    const { cityname } = props.route.params;

    useEffect(() => {
        fetch(`https://api.openweathermap.org/data/2.5/weather?q=${cityname}&appid=${API_KEY}`,)
        .then(res => res.json())
        .then(res => setData(res))
        .catch(err => console.log(err));
    }, []);

    const Data = ({title, value}) =>   

    <View style={{flexDirection:'row', justifyContent:'space-between', alignItems:'center'}}>
    <Text style={{color:'white', fontSize: 22}}>{title}</Text>
    <Text style={{color: 'white', fontSize: 22}}>{value}</Text>
    </View>

    return (
        <View>
            <StatusBar style='light' />
            <ImageBackground source={require('./../assets/img/bg.jpg')} style={{ height: deviceHeight + 40, width: deviceWidth }} imageStyle={{ opacity: 0.6, backgroundColor: 'black' }} />
            <View style={{ position: 'absolute', paddingVertical: 20, paddingHorizontal: 10, }}>
                <View style={{ flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center', width: deviceWidth - 20 }}>
                    <Image source={require('./../assets/img/logo-black.png')} style={{ height: 1, width: 1, borderRadius: 50 }} />
                    <Icon name='menu' size={46} color='white' />
                </View>

                {
                data ? ( <View style={{flexDirection: 'column', justifyContent: 'space-evenly', alignItems: 'center', height: deviceHeight - 100}}>
                    <View>
                    <Text style={{color: 'white', fontSize: 40}}>{cityname}</Text>
                    <Text style={{fontSize: 22, color: 'white', textAlign:'center'}}>{data['weather'][0]['main']}</Text>
                    </View>
                    <Text style={{color: 'white', fontSize:64}}>{(data['main']['temp'] -273).toFixed(2)}&deg; C</Text>

                    <View>
                    <Text style={{color: 'white', fontSize: 22, marginBottom: 16}}>Időjárás részletek</Text>
                    <View style={{width: deviceWidth-60}}>
                        <Data value={`${data['wind']['speed']}km/h`} title='Szélsebesség' />
                        <Data value={`${data['main']['pressure']}hPa`} title='Légnyomás' />
                        <Data value={`${data['main']['humidity']}%`} title='Páratartalom' />
                        <Data value={`${data['visibility']}m`} title='Láthatóság' />
                    </View>
                    </View>
                </View>) : null
                }
            </View>
        </View>
    );
}

